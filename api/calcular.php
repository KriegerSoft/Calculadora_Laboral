<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit(0);
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

function convertDateToMinutes(string $date) {
    list($hours, $minutes) = explode(":", $date);
    return ($hours * 60) + $minutes;
}

function normalizeAttendanceInterval($inMinutes, $outMinutes) {
    if ($outMinutes <= $inMinutes) {
        $outMinutes += 24 * 60;
    }
    return [$inMinutes, $outMinutes];
}

function classifyAttendances($concepts, $attendanceIn, $attendanceOut) {
    $attendanceInMins = convertDateToMinutes($attendanceIn);
    $attendanceOutMins = convertDateToMinutes($attendanceOut);

    list($attendanceInMins, $attendanceOutMins) = normalizeAttendanceInterval($attendanceInMins, $attendanceOutMins);

    usort($concepts, function($a, $b) {
        $order = ['HO' => 0, 'HED' => 1, 'HEN' => 2];
        $aOrder = $order[$a['id']] ?? 3;
        $bOrder = $order[$b['id']] ?? 3;
        return $aOrder - $bOrder;
    });

    $remainingStart = $attendanceInMins;
    $result = [];

    foreach ($concepts as $concept) {
        $conceptStart = convertDateToMinutes($concept['start']);
        $conceptEnd = convertDateToMinutes($concept['end']);
        list($conceptStart, $conceptEnd) = normalizeAttendanceInterval($conceptStart, $conceptEnd);

        $intersectStart = max($remainingStart, $conceptStart);
        $intersectEnd = min($attendanceOutMins, $conceptEnd);

        if ($intersectStart < $intersectEnd) {
            $result[$concept['id']] = ($intersectEnd - $intersectStart) / 60.0;
            $remainingStart = $intersectEnd;
            
            if ($remainingStart >= $attendanceOutMins) {
                break;
            }
        }
    }

    return $result;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        
        $attendanceIn = $input['attendanceIn'] ?? '';
        $attendanceOut = $input['attendanceOut'] ?? '';
        $concepts = $input['concepts'] ?? [];
        
        if ($attendanceIn && $attendanceOut && !empty($concepts)) {
            $result = classifyAttendances($concepts, $attendanceIn, $attendanceOut);
            echo json_encode($result);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}
?>