<?php
session_start();
$usuario_nombre = $_SESSION['usuario_nombre'] ?? 'Admin';

// Obtener filtros desde GET
$tipo = $_GET['tipo'] ?? '';
$anio = $_GET['anio'] ?? '';
$letra = $_GET['letra'] ?? '';
$numero = $_GET['numero'] ?? '';

// Aquí deberías hacer la consulta real a la base de datos según los filtros
// Para mostrar el ejemplo, usamos datos simulados:
$expedientes = [
    [
        'numero' => '1001',
        'letra' => 'A',
        'anio' => 2022,
        'fecha_ingreso' => '2022-08-15',
        'lugar' => 'Mesa de Entrada',
        'tipo' => 'Proyecto de Ordenanza'
    ],
    [
        'numero' => '1002',
        'letra' => 'B',
        'anio' => 2023,
        'fecha_ingreso' => '2023-02-10',
        'lugar' => 'Oficina Central',
        'tipo' => 'Resolución'
    ]
];

// Filtro simple de ejemplo (adapta a tu lógica real)
$resultados = array_filter($expedientes, function($exp) use ($tipo, $anio, $letra, $numero) {
    $ok = true;
    if ($tipo && $exp['tipo'] !== $tipo) $ok = false;
    if ($anio && $exp['anio'] != $anio) $ok = false;
    if ($letra && $exp['letra'] !== $letra) $ok = false;
    if ($numero && $exp['numero'] !== $numero) $ok = false;
    return $ok;
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Expedientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/expedientes/publico/css/estilos.css">
    <style>
        .card-resultados {
            max-width: 900px;
            margin: 48px auto;
            border-radius: 18px;
            box-shadow: 0 4px 24px 0 rgba(70, 89, 125, 0.08);
        }
        .titulo-principal {
            font-weight: 700;
            color: #203864;
        }
        @media (max-width: 767px) {
            .card-resultados {
                margin: 24px auto;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER CON LOGO -->
    <nav class="navbar navbar-expand-lg header-dashboard shadow-sm py-3">
        <div class="container-fluid d-flex align-items-center justify-content-between px-0">
            <div class="d-flex align-items-center">
                <img src="/expedientes/publico/imagen/LOGOCDE.png" alt="Logo" class="logo-header me-3" style="height:76px;">
                <span class="fs-4 fw-bold titulo-header">Expedientes</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3 text-secondary">Usuario: <strong><?= htmlspecialchars($usuario_nombre) ?></strong></span>
                <a href="/expedientes/logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Salir</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar-dashboard col-12 col-md-2 d-md-block sidebar px-0 py-4">
                <div class="text-center mb-4">
                    <span class="fs-4 fw-bold logo-dashboard">Expedientes</span>
                </div>
                <ul class="nav flex-column gap-1 menu-dashboard">
                    <li class="nav-item">
                        <a class="nav-link" href="/expedientes/vistas/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/expedientes/vistas/carga_expedientes.php"><i class="bi bi-archive me-2"></i>Carga de Expediente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/expedientes/vistas/carga_iniciador.php"><i class="bi bi-person-plus me-2"></i>Carga de Iniciador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/expedientes/vistas/consulta.php"><i class="bi bi-list-task me-2"></i>Consulta</a>
                    </li>
                </ul>
            </nav>
            <!-- Main Content -->
            <main class="col-12 col-md-10 ms-sm-auto px-4 main-dashboard">
                <div class="main-box resultados py-4">
                    <div class="card card-resultados shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="titulo-principal mb-0">Resultados de Expedientes</h2>
                                <a href="#" class="btn btn-outline-success btn-exportar" title="Exportar resultados">
                                    <i class="bi bi-box-arrow-down"></i> Exportar
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 tabla-resultados">
                                    <thead class="table-light">
                                        <tr>
                                            <th>N° Expediente</th>
                                            <th>Letra</th>
                                            <th>Año</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Lugar</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultados as $exp): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($exp['numero']) ?></td>
                                            <td><?= htmlspecialchars($exp['letra']) ?></td>
                                            <td><?= htmlspecialchars($exp['anio']) ?></td>
                                            <td><?= htmlspecialchars($exp['fecha_ingreso']) ?></td>
                                            <td><?= htmlspecialchars($exp['lugar']) ?></td>
                                            <td class="text-center">
                                                <a href="ver_detalle.php?numero=<?= urlencode($exp['numero']) ?>&letra=<?= urlencode($exp['letra']) ?>&anio=<?= urlencode($exp['anio']) ?>"
                                                class="btn btn-primary btn-sm me-1 btn-ver-detalle" title="Ver Detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="descargar.php?numero=<?= urlencode($exp['numero']) ?>&letra=<?= urlencode($exp['letra']) ?>&anio=<?= urlencode($exp['anio']) ?>"
                                                class="btn btn-outline-secondary btn-sm btn-descargar" title="Descargar">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($resultados)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No se encontraron expedientes.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <a href="consulta.php" class="btn btn-secondary">Nueva consulta</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>