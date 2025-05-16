$(document).ready(function() {
    $('#calculate-btn').click(function() {
        const attendanceIn = $('#attendanceIn').val();
        const attendanceOut = $('#attendanceOut').val();

        if (!attendanceIn || !attendanceOut) {
            alert('Por favor ingrese ambas horas');
            return;
        }

        const concepts = [];
        $('.concept-card').each(function() {
            const concept = {
                id: $(this).find('.concept-id').val(),
                name: $(this).find('.concept-name').val(),
                start: $(this).find('.concept-start').val(),
                end: $(this).find('.concept-end').val()
            };
            concepts.push(concept);
        });

        if (concepts.length === 0) {
            alert('Debe configurar al menos un concepto');
            return;
        }

        $('#calculate-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Calculando...');

        $.ajax({
            url: 'api/calcular.php',
            type: 'POST',
            dataType: 'json',
            data: {
                attendanceIn: attendanceIn,
                attendanceOut: attendanceOut,
                concepts: concepts
            },
            success: function(response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    displayResults(response);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al conectar con el servidor: ' + error);
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#calculate-btn').prop('disabled', false).html('<i class="fas fa-calculator me-2"></i>Calcular Horas');
            }
        });
    });

    function displayResults(data) {
        const $resultsList = $('#results-list');
        $resultsList.empty();

        const orderedResults = {};
        ['HO', 'HED', 'HEN'].forEach(concept => {
            if (data[concept]) {
                orderedResults[concept] = data[concept];
            }
        });

        for (const [key, value] of Object.entries(data)) {
            if (!['HO', 'HED', 'HEN'].includes(key)) {
                orderedResults[key] = value;
            }
        }

        for (const [key, value] of Object.entries(orderedResults)) {
            const badgeClass = getBadgeClass(key);
            $resultsList.append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${getConceptName(key)}
                    <span class="badge ${badgeClass} rounded-pill">${value.toFixed(2)} horas</span>
                </li>
            `);
        }

        $('#results').removeClass('d-none');
    }

    function getBadgeClass(concept) {
        switch(concept) {
            case 'HO': return 'bg-primary';
            case 'HED': return 'bg-warning text-dark';
            case 'HEN': return 'bg-danger';
            default: return 'bg-secondary';
        }
    }

    function getConceptName(conceptId) {
        const conceptCard = $(`.concept-card .concept-id[value="${conceptId}"]`).closest('.concept-card');
        return conceptCard.find('.concept-name').val() || conceptId;
    }
});