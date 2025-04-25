// Script específico para la página de Seguimiento a Plan de Mejora

// Datos de ejemplo para actas de compromiso


// Función para cargar la tabla de seguimiento
function cargarTablaSeguimiento(actas = actasCompromiso) {
    const tabla = document.getElementById('tablaSeguimiento');
    const tbody = tabla.querySelector('tbody');

    // Limpiar tabla
    tbody.innerHTML = '';

    // Actualizar contadores
    document.getElementById('totalActas').textContent = actas.length;
    document.getElementById('actasActivas').textContent = actas.filter(a => a.estado === 'activo').length;
    document.getElementById('actasCerradas').textContent = actas.filter(a => a.estado === 'cerrado').length;

    // Agregar filas a la tabla
    actas.forEach(acta => {
        const tr = document.createElement('tr');

        // Definir el color de la calificación
        let colorCalificacion = '';
        if (acta.calificacion < 3.0) {
            colorCalificacion = 'text-danger fw-bold';
        } else if (acta.calificacion < 3.5) {
            colorCalificacion = 'text-warning fw-bold';
        } else {
            colorCalificacion = 'text-primary fw-bold';
        }

        // Definir la clase del badge de estado
        let estadoClass = '';
        switch (acta.estado) {
            case 'activo':
                estadoClass = 'badge-estado badge-activo';
                break;
            case 'cerrado':
                estadoClass = 'badge-estado badge-cerrado';
                break;
            case 'pendiente':
                estadoClass = 'badge-estado badge-pendiente';
                break;
            default:
                estadoClass = 'badge-estado badge-activo';
        }

        // Crear contenido de la fila
        tr.innerHTML = `
            <td>${acta.docente.nombre} ${acta.docente.apellido}</td>
            <td>${acta.departamento}</td>
            <td>${acta.asignatura}</td>
            <td class="${colorCalificacion}">${acta.calificacion.toFixed(1)}</td>
            <td>${acta.fechaActa}</td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: ${acta.progreso}%" 
                        aria-valuenow="${acta.progreso}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="ms-2">${acta.progreso}%</small>
            </td>
            <td><span class="badge ${estadoClass}">${acta.estado.charAt(0).toUpperCase() + acta.estado.slice(1)}</span></td>
            <td>
                <button class="btn btn-primary btn-sm btn-circle ver-detalles" data-id="${acta.id}" title="Ver detalles">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
    });

    // Agregar eventos a los botones de ver detalles
    document.querySelectorAll('.ver-detalles').forEach(btn => {
        btn.addEventListener('click', function () {
            const actaId = parseInt(this.getAttribute('data-id'));
            mostrarDetallesActa(actaId);
        });
    });
}

// Función para mostrar los detalles de un acta en el modal
function mostrarDetallesActa(id) {
    const acta = actasCompromiso.find(a => a.id === id);
    if (!acta) return;

    // Actualizar información del docente
    document.getElementById('modalNombreDocente').textContent = `${acta.docente.nombre} ${acta.docente.apellido}`;
    document.getElementById('modalDepartamento').textContent = acta.departamento;
    document.getElementById('modalAsignatura').textContent = acta.asignatura;

    // Actualizar información del acta
    document.getElementById('modalNumeroActa').textContent = acta.numeroActa;
    document.getElementById('modalFechaActa').textContent = acta.fechaActa;

    // Actualizar calificación con color
    const modalCalificacion = document.getElementById('modalCalificacion');
    modalCalificacion.textContent = acta.calificacion.toFixed(1);
    if (acta.calificacion < 3.0) {
        modalCalificacion.className = 'text-danger fw-bold';
    } else if (acta.calificacion < 3.5) {
        modalCalificacion.className = 'text-warning fw-bold';
    } else {
        modalCalificacion.className = 'text-primary fw-bold';
    }

    // Actualizar retroalimentación
    document.getElementById('modalRetroalimentacion').innerHTML = acta.retroalimentacion;

    // Actualizar historial de notas
    const historialNotas = document.getElementById('historialNotas');
    historialNotas.innerHTML = '';

    if (acta.notas && acta.notas.length > 0) {
        acta.notas.forEach(nota => {
            const notaElement = document.createElement('div');
            notaElement.className = 'nota-seguimiento';
            notaElement.innerHTML = `
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">${nota.autor}</span>
                    <span class="nota-fecha">${nota.fecha}</span>
                </div>
                <p class="mb-0 mt-1">${nota.texto}</p>
            `;
            historialNotas.appendChild(notaElement);
        });
    } else {
        historialNotas.innerHTML = '<p class="text-muted">No hay notas de seguimiento registradas.</p>';
    }

    // Actualizar progreso
    document.getElementById('modalProgresoBar').style.width = `${acta.progreso}%`;
    document.getElementById('modalProgresoBar').setAttribute('aria-valuenow', acta.progreso);
    document.getElementById('modalProgresoTexto').textContent = `${acta.progreso}%`;

    // Actualizar estado
    const modalEstadoBadge = document.getElementById('modalEstadoBadge');
    modalEstadoBadge.textContent = acta.estado.charAt(0).toUpperCase() + acta.estado.slice(1);
    modalEstadoBadge.className = 'badge badge-estado';
    switch (acta.estado) {
        case 'activo':
            modalEstadoBadge.classList.add('badge-activo');
            break;
        case 'cerrado':
            modalEstadoBadge.classList.add('badge-cerrado');
            break;
        case 'pendiente':
            modalEstadoBadge.classList.add('badge-pendiente');
            break;
    }

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalDetallesSeguimiento'));
    modal.show();
}

// Función para filtrar actas según los criterios seleccionados
function filtrarActas() {
    const departamento = document.getElementById('departamentoFilter').value;
    const estado = document.getElementById('estadoFilter').value;
    const busqueda = document.getElementById('searchInput').value.toLowerCase();

    let actasFiltradas = [...actasCompromiso];

    // Filtrar por departamento
    if (departamento) {
        actasFiltradas = actasFiltradas.filter(acta => acta.departamento === departamento);
    }

    // Filtrar por estado
    if (estado) {
        actasFiltradas = actasFiltradas.filter(acta => acta.estado === estado);
    }

    // Filtrar por búsqueda
    if (busqueda) {
        actasFiltradas = actasFiltradas.filter(acta => {
            const nombreCompleto = `${acta.docente.nombre} ${acta.docente.apellido}`.toLowerCase();
            return nombreCompleto.includes(busqueda) ||
                acta.asignatura.toLowerCase().includes(busqueda) ||
                acta.departamento.toLowerCase().includes(busqueda);
        });
    }

    // Actualizar la tabla con los resultados filtrados
    cargarTablaSeguimiento(actasFiltradas);
}

// Función para agregar una nueva nota de seguimiento
function agregarNotaSeguimiento(actaId, texto) {
    const acta = actasCompromiso.find(a => a.id === actaId);
    if (!acta) return false;

    // Obtener fecha actual
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2, '0');
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const anio = hoy.getFullYear();
    const fechaActual = `${dia}/${mes}/${anio}`;

    // Crear nueva nota
    const nuevaNota = {
        fecha: fechaActual,
        texto: texto,
        autor: 'Coordinador ' + acta.departamento // Usar el departamento para personalizar el autor
    };

    // Agregar la nota al acta
    acta.notas.push(nuevaNota);

    return true;
}

// Función para actualizar el progreso de un plan de mejora
function actualizarProgreso(actaId, nuevoProgreso) {
    const acta = actasCompromiso.find(a => a.id === actaId);
    if (!acta) return false;

    // Actualizar el progreso
    acta.progreso = nuevoProgreso;

    // Si el progreso es 100%, preguntar si desea cerrar el acta
    if (nuevoProgreso === 100 && acta.estado !== 'cerrado') {
        if (confirm('El progreso ha llegado al 100%. ¿Desea cerrar el acta de compromiso?')) {
            acta.estado = 'cerrado';
        }
    }

    return true;
}

// Función para cambiar el estado de un acta
function cambiarEstadoActa(actaId, nuevoEstado) {
    const acta = actasCompromiso.find(a => a.id === actaId);
    if (!acta) return false;

    // Actualizar el estado
    acta.estado = nuevoEstado;

    return true;
}

// Función para generar un informe de seguimiento
function generarInformeSeguimiento(actaId) {
    const acta = actasCompromiso.find(a => a.id === actaId);
    if (!acta) return false;

    // Llamar a la función de generación de PDF implementada en seguimiento-pdf-generator.js
    if (typeof generarPDFSeguimiento === 'function') {
        return generarPDFSeguimiento(actaId);
    } else {
        alert('Error: No se pudo cargar el generador de PDF para el informe de seguimiento.');
        return false;
    }
}

// Inicializar la página cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {
    // Cargar la tabla de seguimiento
    cargarTablaSeguimiento();

    // Agregar eventos a los filtros
    document.getElementById('departamentoFilter').addEventListener('change', filtrarActas);
    document.getElementById('estadoFilter').addEventListener('change', filtrarActas);
    document.getElementById('searchInput').addEventListener('input', filtrarActas);

    // Evento para agregar nota
    document.getElementById('btnAgregarNota').addEventListener('click', function () {
        const actaId = parseInt(document.querySelector('.ver-detalles[data-id]').getAttribute('data-id'));
        const texto = prompt('Ingrese la nota de seguimiento:');
        if (texto) {
            if (agregarNotaSeguimiento(actaId, texto)) {
                mostrarDetallesActa(actaId); // Actualizar modal
                alert('Nota agregada correctamente.');
            }
        }
    });

    // Evento para actualizar progreso
    document.getElementById('btnActualizarProgreso').addEventListener('click', function () {
        const actaId = parseInt(document.querySelector('.ver-detalles[data-id]').getAttribute('data-id'));
        const nuevoProgreso = prompt('Ingrese el nuevo porcentaje de progreso (0-100):', '0');
        if (nuevoProgreso !== null) {
            const progreso = parseInt(nuevoProgreso);
            if (!isNaN(progreso) && progreso >= 0 && progreso <= 100) {
                if (actualizarProgreso(actaId, progreso)) {
                    mostrarDetallesActa(actaId); // Actualizar modal
                    cargarTablaSeguimiento(); // Actualizar tabla
                    alert('Progreso actualizado correctamente.');
                }
            } else {
                alert('Por favor, ingrese un número válido entre 0 y 100.');
            }
        }
    });

    // Evento para cambiar estado
    document.getElementById('btnCambiarEstado').addEventListener('click', function () {
        const actaId = parseInt(document.querySelector('.ver-detalles[data-id]').getAttribute('data-id'));
        const acta = actasCompromiso.find(a => a.id === actaId);
        if (!acta) return;

        let nuevoEstado = '';
        if (acta.estado === 'activo') {
            nuevoEstado = confirm('¿Desea cerrar el acta de compromiso?') ? 'cerrado' : 'activo';
        } else if (acta.estado === 'cerrado') {
            nuevoEstado = confirm('¿Desea reabrir el acta de compromiso?') ? 'activo' : 'cerrado';
        } else if (acta.estado === 'pendiente') {
            nuevoEstado = confirm('¿Desea activar el acta de compromiso?') ? 'activo' : 'pendiente';
        }

        if (nuevoEstado && nuevoEstado !== acta.estado) {
            if (cambiarEstadoActa(actaId, nuevoEstado)) {
                mostrarDetallesActa(actaId); // Actualizar modal
                cargarTablaSeguimiento(); // Actualizar tabla
                alert('Estado actualizado correctamente.');
            }
        }
    });

    // Evento para generar informe
    document.getElementById('btnGenerarInforme').addEventListener('click', function () {
        const actaId = parseInt(document.querySelector('.ver-detalles[data-id]').getAttribute('data-id'));
        generarInformeSeguimiento(actaId);
    });
});