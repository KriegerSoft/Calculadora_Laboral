<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Horas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .concept-card {
            transition: all 0.3s;
        }
        .concept-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center mb-4">Calculadora de Horas Laborales</h1>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Configuración de Conceptos</h5>
                </div>
                <div class="card-body">
                    <div id="concepts-container">
                        <!-- Concepto HO -->
                        <div class="card mb-3 concept-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">ID Concepto</label>
                                        <input type="text" class="form-control concept-id" value="HO" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control concept-name" value="Horas Ordinarias">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Inicio</label>
                                        <input type="time" class="form-control concept-start" value="08:00">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Fin</label>
                                        <input type="time" class="form-control concept-end" value="17:59">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Concepto HED -->
                        <div class="card mb-3 concept-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">ID Concepto</label>
                                        <input type="text" class="form-control concept-id" value="HED" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control concept-name" value="Horas Extras Diurnas">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Inicio</label>
                                        <input type="time" class="form-control concept-start" value="18:00">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Fin</label>
                                        <input type="time" class="form-control concept-end" value="20:59">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Concepto HEN -->
                        <div class="card mb-3 concept-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">ID Concepto</label>
                                        <input type="text" class="form-control concept-id" value="HEN" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control concept-name" value="Horas Extras Nocturnas">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Inicio</label>
                                        <input type="time" class="form-control concept-start" value="21:00">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hora Fin</label>
                                        <input type="time" class="form-control concept-end" value="05:59">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Registro de Horario</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Hora de Entrada</label>
                            <input type="time" class="form-control" id="attendanceIn" value="08:00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hora de Salida</label>
                            <input type="time" class="form-control" id="attendanceOut" value="19:00">
                        </div>
                    </div>
                    <button id="calculate-btn" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-calculator me-2"></i>Calcular Horas
                    </button>
                </div>
            </div>

            <div id="results" class="card d-none">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Resultados</h5>
                </div>
                <div class="card-body">
                    <ul id="results-list" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>