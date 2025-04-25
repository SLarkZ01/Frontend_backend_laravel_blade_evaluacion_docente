// Script específico para la página de Proceso de Sanción o Retiro

// Variable global para almacenar los docentes con bajo desempeño
let docentes = [];

// Función para cargar los docentes con bajo desempeño desde la API
async function cargarDocentesBajoDesempeno() {
    try {
        const response = await fetch('/api/procesos-sancion/docentes/bajo-desempeno');
        if (!response.ok) {
            throw new Error('Error al cargar docentes con bajo desempeño');
        }
        docentes = await response.json();
        
        // Llenar el select de docentes
        const docenteSelect = document.getElementById('docenteSelect');
        if (docenteSelect) {
            docenteSelect.innerHTML = '<option value="">Seleccione un docente</option>';
            docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.id;
                option.textContent = `${docente.nombre} ${docente.apellido} - ${docente.asignatura}`;
                docenteSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error al cargar los docentes con bajo desempeño', 'danger');
    }
}

// Generar número de resolución aleatorio
function generarNumeroResolucion() {
    return 'RES-' + Math.floor(Math.random() * 9000) + 1000 + '-' + new Date().getFullYear();
}

// Establecer fecha actual
function establecerFechaActual() {
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2, '0');
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const anio = hoy.getFullYear();
    return `${dia}/${mes}/${anio}`;
}

// Función global para cargar datos del docente
function cargarDatosDocente(id) {
    const docente = docentes.find(d => d.id === parseInt(id));
    if (docente) {
        // Actualizar número de resolución
        document.getElementById('numeroResolucion').value = generarNumeroResolucion();

        // Actualizar fecha de emisión
        document.getElementById('fechaEmision').value = establecerFechaActual();

        // Actualizar datos del docente
        document.getElementById('nombreDocente').value = docente.nombre;
        document.getElementById('apellidoDocente').value = docente.apellido;
        document.getElementById('identificacionDocente').value = docente.identificacion;
        document.getElementById('asignaturaDocente').value = docente.asignatura;

        // Actualizar calificación
        const calificacionInput = document.getElementById('calificacionDocente');
        calificacionInput.value = docente.calificacion.toFixed(1);

        // Aplicar estilo según calificación
        if (docente.calificacion < 3.0) {
            calificacionInput.style.color = '#dc3545'; // Rojo para calificaciones muy bajas
            calificacionInput.style.fontWeight = 'bold';
            // Preseleccionar sanción más severa para calificaciones muy bajas
            document.getElementById('tipoSancionSelect').value = 'retiro';
        } else if (docente.calificacion < 3.5) {
            calificacionInput.style.color = '#fd7e14'; // Naranja para calificaciones bajas
            calificacionInput.style.fontWeight = 'bold';
            // Preseleccionar sanción intermedia para calificaciones bajas
            document.getElementById('tipoSancionSelect').value = 'grave';
        } else {
            calificacionInput.style.color = '#ffc107'; // Amarillo para calificaciones cercanas a 3
            calificacionInput.style.fontWeight = 'bold';
            // Preseleccionar sanción leve para calificaciones cercanas al umbral
            document.getElementById('tipoSancionSelect').value = 'leve';
        }

        // Actualizar el contenido de los editores Summernote con mensajes personalizados
        actualizarContenidoEditores(docente);
    }
}

// Función para actualizar el contenido de los editores Summernote
function actualizarContenidoEditores(docente) {
    // Antecedentes
    const antecedentes = $('div#antecedentes');
    if (antecedentes.length) {
        let mensaje = `<p>El/La docente <strong>${docente.nombre} ${docente.apellido}</strong> de la asignatura <strong>${docente.asignatura}</strong> `;
        mensaje += `ha obtenido una calificación de <strong>${docente.calificacion.toFixed(1)}</strong> en su evaluación de desempeño, `;
        mensaje += `lo cual está por debajo del umbral mínimo aceptable de 3.0 establecido por la Corporación Universitaria Autónoma del Cauca.</p>`;
        
        if (docente.calificacion < 3.0) {
            mensaje += `<p>Se evidencia un desempeño crítico que requiere medidas inmediatas. El docente ha tenido oportunidades previas para mejorar su desempeño a través del plan de mejora, sin mostrar avances significativos.</p>`;
        } else if (docente.calificacion < 3.5) {
            mensaje += `<p>Se ha identificado un desempeño deficiente que afecta la calidad educativa. A pesar de las recomendaciones y planes de mejora implementados, no se han observado los avances esperados.</p>`;
        } else {
            mensaje += `<p>Se ha identificado un desempeño por debajo del estándar institucional. El docente ha participado en planes de mejora previos con resultados insuficientes.</p>`;
        }
        
        antecedentes.summernote('code', mensaje);
    }

    // Fundamentos Normativos
    const fundamentos = $('div#fundamentos');
    if (fundamentos.length) {
        let mensaje = `<p>La presente resolución se fundamenta en las siguientes normativas institucionales:</p>`;
        mensaje += `<ul>`;
        mensaje += `<li><strong>Estatuto Docente de la Corporación Universitaria Autónoma del Cauca</strong>, Capítulo IV, Artículos 45-52, que establecen el régimen disciplinario aplicable al personal docente.</li>`;
        mensaje += `<li><strong>Reglamento Interno de Trabajo</strong>, Título III, que regula las causales y procedimientos para sanciones y terminación de contratos.</li>`;
        mensaje += `<li><strong>Sistema de Evaluación Docente</strong>, que establece los criterios de calidad y desempeño esperados, así como las consecuencias de no alcanzar los estándares mínimos requeridos.</li>`;
        mensaje += `<li><strong>Acuerdo del Consejo Superior No. 023 de 2022</strong>, que establece el procedimiento para la aplicación de medidas disciplinarias en casos de bajo desempeño docente.</li>`;
        mensaje += `</ul>`;
        
        fundamentos.summernote('code', mensaje);
    }

    // Resolución
    const resolucion = $('div#resolucion');
    if (resolucion.length) {
        let mensaje = '';
        const tipoSancion = document.getElementById('tipoSancionSelect').value;
        
        if (docente.calificacion < 3.0) {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Dar por terminado el contrato laboral con el/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, identificado(a) con documento número <strong>${docente.identificacion}</strong>, `;
            mensaje += `quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> en el departamento de <strong>${docente.departamento}</strong>, `;
            mensaje += `con efectividad a partir del día siguiente a la notificación de la presente resolución.</p>`;
            mensaje += `<p>SEGUNDO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
            mensaje += `<p>TERCERO: Remitir copia de la presente resolución a la Oficina de Talento Humano para los trámites administrativos correspondientes.</p>`;
        } else if (docente.calificacion < 3.5) {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Imponer sanción disciplinaria de suspensión temporal por un período de un (1) mes al/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, `;
            mensaje += `identificado(a) con documento número <strong>${docente.identificacion}</strong>, quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> `;
            mensaje += `en el departamento de <strong>${docente.departamento}</strong>.</p>`;
            mensaje += `<p>SEGUNDO: Durante el período de suspensión, el/la docente deberá participar en un programa intensivo de capacitación pedagógica diseñado por la Vicerrectoría Académica.</p>`;
            mensaje += `<p>TERCERO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
        } else if (tipoSancion === 'leve') {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Imponer sanción disciplinaria de amonestación escrita al/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, `;
            mensaje += `identificado(a) con documento número <strong>${docente.identificacion}</strong>, quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> `;
            mensaje += `en el departamento de <strong>${docente.departamento}</strong>.</p>`;
            mensaje += `<p>SEGUNDO: El/La docente deberá presentar un plan de mejoramiento detallado en un plazo no mayor a quince (15) días calendario, `;
            mensaje += `el cual será evaluado y monitoreado mensualmente por la coordinación académica correspondiente.</p>`;
            mensaje += `<p>TERCERO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
        }
        
        resolucion.summernote('code', mensaje);
    }
}

// Asignar la función al objeto window para que sea accesible desde el HTML
window.cargarDatosDocente = cargarDatosDocente;

// Función para actualizar el contenido según el tipo de sanción seleccionado
function actualizarContenidoSegunSancion() {
    const tipoSancion = document.getElementById('tipoSancionSelect').value;
    const docente = docentes.find(d => d.id === parseInt($('#docenteSelect').val()));
    
    if (!docente) return;
    
    // Actualizar resolución según el tipo de sanción seleccionado
    const resolucion = $('div#resolucion');
    if (resolucion.length) {
        let mensaje = '';
        
        if (tipoSancion === 'retiro') {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Dar por terminado el contrato laboral con el/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, identificado(a) con documento número <strong>${docente.identificacion}</strong>, `;
            mensaje += `quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> en el departamento de <strong>${docente.departamento}</strong>, `;
            mensaje += `con efectividad a partir del día siguiente a la notificación de la presente resolución.</p>`;
            mensaje += `<p>SEGUNDO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
            mensaje += `<p>TERCERO: Remitir copia de la presente resolución a la Oficina de Talento Humano para los trámites administrativos correspondientes.</p>`;
        } else if (tipoSancion === 'grave') {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Imponer sanción disciplinaria de suspensión temporal por un período de un (1) mes al/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, `;
            mensaje += `identificado(a) con documento número <strong>${docente.identificacion}</strong>, quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> `;
            mensaje += `en el departamento de <strong>${docente.departamento}</strong>.</p>`;
            mensaje += `<p>SEGUNDO: Durante el período de suspensión, el/la docente deberá participar en un programa intensivo de capacitación pedagógica diseñado por la Vicerrectoría Académica.</p>`;
            mensaje += `<p>TERCERO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
        } else if (tipoSancion === 'leve') {
            mensaje = `<p><strong>RESUELVE:</strong></p>`;
            mensaje += `<p>PRIMERO: Imponer sanción disciplinaria de amonestación escrita al/la docente <strong>${docente.nombre} ${docente.apellido}</strong>, `;
            mensaje += `identificado(a) con documento número <strong>${docente.identificacion}</strong>, quien se desempeña como docente de la asignatura <strong>${docente.asignatura}</strong> `;
            mensaje += `en el departamento de <strong>${docente.departamento}</strong>.</p>`;
            mensaje += `<p>SEGUNDO: El/La docente deberá presentar un plan de mejoramiento detallado en un plazo no mayor a quince (15) días calendario, `;
            mensaje += `el cual será evaluado y monitoreado mensualmente por la coordinación académica correspondiente.</p>`;
            mensaje += `<p>TERCERO: Notificar personalmente al/la docente del contenido de esta resolución, informándole que contra la misma procede el recurso de reposición ante la Rectoría, `;
            mensaje += `dentro de los cinco (5) días hábiles siguientes a la notificación.</p>`;
        }
        
        resolucion.summernote('code', mensaje);
    }
}

// Asignar la función al objeto window para que sea accesible desde el HTML
window.actualizarContenidoSegunSancion = actualizarContenidoSegunSancion;

// Función para cargar la lista de procesos de sanción
async function cargarListaProcesos() {
    try {
        const response = await fetch('/api/procesos-sancion');
        if (!response.ok) {
            throw new Error('Error al cargar la lista de procesos de sanción');
        }
        const procesosSancion = await response.json();
        
        const tablaProcesos = document.getElementById('tablaProcesos');
        if (tablaProcesos) {
            const tbody = tablaProcesos.querySelector('tbody');
            tbody.innerHTML = '';
            
            if (procesosSancion.length === 0) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td colspan="6" class="text-center">No hay procesos de sanción registrados</td>';
                tbody.appendChild(tr);
                return;
            }
            
            procesosSancion.forEach(proceso => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${proceso.numero_resolucion}</td>
                    <td>${proceso.fecha_emision}</td>
                    <td>${proceso.nombre_docente} ${proceso.apellido_docente}</td>
                    <td>
                        <span class="badge ${proceso.tipo_sancion === 'leve' ? 'bg-warning' : proceso.tipo_sancion === 'grave' ? 'bg-orange' : 'bg-danger'}">
                            ${proceso.tipo_sancion === 'leve' ? 'Leve' : proceso.tipo_sancion === 'grave' ? 'Grave' : 'Retiro'}
                        </span>
                    </td>
                    <td>
                        <span class="badge ${proceso.calificacion_final < 3.0 ? 'bg-danger' : 'bg-warning'}">
                            ${parseFloat(proceso.calificacion_final).toFixed(1)}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" onclick="verProceso(${proceso.id_sancion})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editarProceso(${proceso.id_sancion})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProceso(${proceso.id_sancion})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error al cargar la lista de procesos de sanción', 'danger');
    }
}

// Asignar funciones al objeto window para que sean accesibles desde el HTML
window.verProceso = async function(id) {
    try {
        const response = await fetch(`/api/procesos-sancion/${id}`);
        if (!response.ok) {
            throw new Error('Error al cargar el proceso de sanción');
        }
        const proceso = await response.json();
        
        // Mostrar modal con los datos
        const modalVerProceso = new bootstrap.Modal(document.getElementById('modalVerProceso'));
        
        // Actualizar contenido del modal
        document.getElementById('verNumeroResolucion').textContent = proceso.numero_resolucion;
        document.getElementById('verFechaEmision').textContent = proceso.fecha_emision;
        document.getElementById('verNombreCompleto').textContent = `${proceso.nombre_docente} ${proceso.apellido_docente}`;
        document.getElementById('verIdentificacion').textContent = proceso.identificacion_docente;
        document.getElementById('verAsignatura').textContent = proceso.asignatura;
        document.getElementById('verCalificacion').textContent = parseFloat(proceso.calificacion_final).toFixed(1);
        document.getElementById('verTipoSancion').textContent = proceso.tipo_sancion === 'leve' ? 'Leve' : proceso.tipo_sancion === 'grave' ? 'Grave' : 'Retiro';
        document.getElementById('verAntecedentes').innerHTML = proceso.antecedentes;
        document.getElementById('verFundamentos').innerHTML = proceso.fundamentos;
        document.getElementById('verResolucion').innerHTML = proceso.resolucion;
        
        // Mostrar el modal
        modalVerProceso.show();
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error al cargar el proceso de sanción', 'danger');
    }
};

window.editarProceso = async function(id) {
    try {
        const response = await fetch(`/api/procesos-sancion/${id}`);
        if (!response.ok) {
            throw new Error('Error al cargar el proceso de sanción');
        }
        const proceso = await response.json();
        procesoActual = proceso;
        
        // Cargar datos en el formulario
        $('#id_sancion').val(proceso.id_sancion);
        $('#numeroResolucion').val(proceso.numero_resolucion);
        $('#fechaEmision').val(proceso.fecha_emision);
        $('#nombreDocente').val(proceso.nombre_docente);
        $('#apellidoDocente').val(proceso.apellido_docente);
        $('#identificacionDocente').val(proceso.identificacion_docente);
        $('#asignaturaDocente').val(proceso.asignatura);
        $('#calificacionDocente').val(parseFloat(proceso.calificacion_final).toFixed(1));
        $('#tipoSancionSelect').val(proceso.tipo_sancion);
        
        // Cargar contenido en los editores Summernote
        $('#antecedentes').summernote('code', proceso.antecedentes);
        $('#fundamentos').summernote('code', proceso.fundamentos);
        $('#resolucion').summernote('code', proceso.resolucion);
        
        // Mostrar firma si existe
        if (proceso.firma_path) {
            $('#firma-imagen').attr('src', `/storage/${proceso.firma_path}`);
            $('#firma-preview').removeClass('d-none');
            $('#firma-placeholder').addClass('d-none');
            $('#eliminar-firma').removeClass('d-none');
        }
        
        // Mostrar formulario en modo edición
        mostrarFormulario(true);
    } catch (error) {
        console.error('Error:', error);
        mostrarAlerta('Error al cargar el proceso de sanción', 'danger');
    }
};

window.eliminarProceso = async function(id) {
    if (confirm('¿Está seguro que desea eliminar este proceso de sanción? Esta acción no se puede deshacer.')) {
        try {
            const response = await fetch(`/api/procesos-sancion/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!response.ok) {
                throw new Error('Error al eliminar el proceso de sanción');
            }
            
            const result = await response.json();
            Swal.fire({
                title: '¡Eliminado!',
                text: result.message || 'El proceso de sanción ha sido eliminado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Recargar la lista de procesos
                cargarListaProcesos();
            });
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'No se pudo eliminar el proceso de sanción',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
    // Cargar los docentes con bajo desempeño al cargar la página
    cargarDocentesBajoDesempeno();
    
    // Cargar la lista de procesos de sanción existentes
    cargarListaProcesos();
    
    // Evento submit para el formulario de proceso de sanción
    $('#form-proceso-sancion').on('submit', function(e) {
        e.preventDefault();
        guardarProceso();
    });
    
    // Inicializar Summernote para los editores de texto enriquecido
    $('#antecedentes, #fundamentos, #resolucion').summernote({
        placeholder: 'Escriba aquí...',
        tabsize: 2,
        height: 150,
        dialogsInBody: true,
        dialogsFade: true,
        container: 'body',
        focus: false,
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            link: [
                ['link', ['linkDialogShow', 'unlink']]
            ],
            air: []
        },
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['picture', 'link', 'video']],
            ['view', ['codeview', 'help']]
        ]
    });
    
    // Manejar carga de firma
    $('#seleccionar-firma').click(function() {
        $('#firma-input').click();
    });

    $('#firma-input').change(function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#firma-imagen').attr('src', e.target.result);
                $('#firma-preview').removeClass('d-none');
                $('#firma-placeholder').addClass('d-none');
                $('#eliminar-firma').removeClass('d-none');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    $('#eliminar-firma').click(function() {
        $('#firma-input').val('');
        $('#firma-preview').addClass('d-none');
        $('#firma-placeholder').removeClass('d-none');
        $(this).addClass('d-none');
    });
    
    // Botón para mostrar formulario de nuevo proceso
    $('#btn-nuevo-proceso').click(function() {
        mostrarFormulario();
    });

    // Botón para cancelar formulario
    $('#btn-cancelar').click(function() {
        ocultarFormulario();
    });

    // Manejar envío del formulario
    $('#form-proceso-sancion').submit(function(e) {
        e.preventDefault();
        guardarProceso();
    });

    // Botón para generar PDF
    $('#btn-generar-pdf').click(function() {
        generarPDF();
    });

    // Botón para enviar al docente
    $('#btn-enviar').click(function() {
        if (procesoActual) {
            enviarProceso(procesoActual.id_sancion);
        } else {
            mostrarAlerta('warning', 'Primero debe guardar el proceso antes de enviarlo');
        }
    });
    
    /**
     * Muestra el formulario para crear/editar un proceso de sanción
     */
    function mostrarFormulario(editar = false) {
        modoEdicion = editar;
        $('#form-title').text(editar ? 'Editar Proceso de Sanción' : 'Nuevo Proceso de Sanción');
        $('#formulario-sancion').show();
        $('html, body').animate({
            scrollTop: $('#formulario-sancion').offset().top - 100
        }, 500);
    }

    /**
     * Oculta el formulario y limpia los campos
     */
    function ocultarFormulario() {
        $('#formulario-sancion').hide();
        limpiarFormulario();
    }

    /**
     * Limpia todos los campos del formulario
     */
    function limpiarFormulario() {
        $('#form-proceso-sancion')[0].reset();
        $('#id_sancion').val('');
        $('.summernote').summernote('code', '');
        $('#firma-input').val('');
        $('#firma-preview').addClass('d-none');
        $('#firma-placeholder').removeClass('d-none');
        $('#eliminar-firma').addClass('d-none');
        procesoActual = null;
    }

    /**
     * Guarda un nuevo proceso o actualiza uno existente
     */
    function guardarProceso() {
        // Crear FormData para enviar archivos
        const formData = new FormData($('#form-proceso-sancion')[0]);
        
        // Agregar contenido de los editores Summernote
        formData.set('antecedentes', $('#antecedentes').summernote('code'));
        formData.set('fundamentos', $('#fundamentos').summernote('code'));
        formData.set('resolucion', $('#resolucion').summernote('code'));
        
        const url = modoEdicion 
            ? `/api/procesos-sancion/${$('#id_sancion').val()}` 
            : '/api/procesos-sancion';
        
        const method = modoEdicion ? 'PUT' : 'POST';
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere mientras se guarda el proceso',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Enviar solicitud AJAX
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: '¡Guardado exitoso!',
                    text: response.message || 'El proceso de sanción ha sido guardado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    ocultarFormulario();
                    window.location.reload();
                });
            },
            error: function(xhr) {
                const errores = xhr.responseJSON?.errors || { error: 'Ha ocurrido un error al guardar el proceso' };
                let mensajeError = '';
                
                for (const campo in errores) {
                    mensajeError += `${errores[campo]} <br>`;
                }
                
                Swal.fire({
                    title: 'Error',
                    html: mensajeError,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }

    /**
     * Carga un proceso para edición
     */
    function editarProceso(id) {
        $.ajax({
            url: `/decano/proceso-sancion/${id}`,
            type: 'GET',
            success: function(proceso) {
                procesoActual = proceso;
                
                // Cargar datos en el formulario
                $('#id_sancion').val(proceso.id_sancion);
                $('#numeroResolucion').val(proceso.numero_resolucion);
                $('#fechaEmision').val(proceso.fecha_emision);
                $('#nombreDocente').val(proceso.nombre_docente);
                $('#apellidoDocente').val(proceso.apellido_docente);
                $('#identificacionDocente').val(proceso.identificacion_docente);
                $('#asignaturaDocente').val(proceso.asignatura);
                $('#calificacionDocente').val(proceso.calificacion_final);
                $('#tipoSancionSelect').val(proceso.tipo_sancion);
                
                // Cargar contenido en los editores Summernote
                $('#antecedentes').summernote('code', proceso.antecedentes);
                $('#fundamentos').summernote('code', proceso.fundamentos);
                $('#resolucion').summernote('code', proceso.resolucion);
                
                // Mostrar firma si existe
                if (proceso.firma_path) {
                    $('#firma-imagen').attr('src', `/storage/${proceso.firma_path}`);
                    $('#firma-preview').removeClass('d-none');
                    $('#firma-placeholder').addClass('d-none');
                    $('#eliminar-firma').removeClass('d-none');
                }
                
                // Mostrar formulario en modo edición
                mostrarFormulario(true);
            },
            error: function() {
                mostrarAlerta('danger', 'No se pudo cargar el proceso de sanción');
            }
        });
    }

    /**
     * Elimina un proceso de sanción
     */
    function eliminarProceso(id) {
        if (confirm('¿Está seguro que desea eliminar este proceso de sanción? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: `/decano/proceso-sancion/${id}`,
                type: 'DELETE',
                success: function(response) {
                    mostrarAlerta('success', response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function() {
                    mostrarAlerta('danger', 'No se pudo eliminar el proceso de sanción');
                }
            });
        }
    }

    /**
     * Marca un proceso como enviado
     */
    function enviarProceso(id) {
        if (confirm('¿Está seguro que desea enviar este proceso de sanción al docente? Una vez enviado, no podrá modificarlo.')) {
            $.ajax({
                url: `/decano/proceso-sancion/${id}/enviar`,
                type: 'PUT',
                success: function(response) {
                    mostrarAlerta('success', response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function() {
                    mostrarAlerta('danger', 'No se pudo enviar el proceso de sanción');
                }
            });
        }
    }

    /**
     * Filtra procesos por departamento
     */
    function filtrarPorDepartamento(departamento) {
        if (!departamento) {
            window.location.reload();
            return;
        }
        
        $.ajax({
            url: '/decano/filtrar-proceso-sancion-departamento',
            type: 'GET',
            data: { departamento: departamento },
            success: function(procesos) {
                actualizarTablaProcesos(procesos);
            },
            error: function() {
                mostrarAlerta('danger', 'Error al filtrar por departamento');
            }
        });
    }

    /**
     * Filtra procesos por rango de calificación
     */
    function filtrarPorCalificacion(opcion) {
        if (!opcion) {
            window.location.reload();
            return;
        }
        
        let min = 0;
        let max = 5;
        
        switch(opcion) {
            case '1': // Menor a 2.5
                min = 0;
                max = 2.49;
                break;
            case '2': // Entre 2.5 y 2.7
                min = 2.5;
                max = 2.7;
                break;
            case '3': // Entre 2.7 y 3.0
                min = 2.71;
                max = 3.0;
                break;
        }
        
        $.ajax({
            url: '/decano/filtrar-proceso-sancion-calificacion',
            type: 'GET',
            data: { calificacion_min: min, calificacion_max: max },
            success: function(procesos) {
                actualizarTablaProcesos(procesos);
            },
            error: function() {
                mostrarAlerta('danger', 'Error al filtrar por calificación');
            }
        });
    }

    /**
     * Actualiza la tabla de procesos con los resultados filtrados
     */
    function actualizarTablaProcesos(procesos) {
        const tabla = $('#tabla-procesos');
        tabla.empty();
        
        if (procesos.length === 0) {
            tabla.append('<tr><td colspan="8" class="text-center">No se encontraron procesos de sanción</td></tr>');
            return;
        }
        
        procesos.forEach(proceso => {
            let tipoSancionBadge = '';
            if (proceso.tipo_sancion === 'leve') {
                tipoSancionBadge = '<span class="badge bg-warning">Leve</span>';
            } else if (proceso.tipo_sancion === 'grave') {
                tipoSancionBadge = '<span class="badge bg-danger">Grave</span>';
            } else if (proceso.tipo_sancion === 'retiro') {
                tipoSancionBadge = '<span class="badge bg-dark">Retiro</span>';
            }
            
            const estadoBadge = proceso.enviado 
                ? '<span class="badge bg-success">Enviado</span>'
                : '<span class="badge bg-secondary">Borrador</span>';
            
            const enviarBoton = proceso.enviado ? '' : `
                <button class="btn btn-sm btn-success" onclick="enviarProceso(${proceso.id_sancion})">
                    <i class="fas fa-paper-plane"></i>
                </button>
            `;
            
            const fila = `
                <tr>
                    <td>${proceso.numero_resolucion}</td>
                    <td>${formatearFecha(proceso.fecha_emision)}</td>
                    <td>${proceso.nombre_docente} ${proceso.apellido_docente}</td>
                    <td>${proceso.asignatura}</td>
                    <td class="${proceso.calificacion_final < 3.0 ? 'text-danger' : ''}">${proceso.calificacion_final}</td>
                    <td>${tipoSancionBadge}</td>
                    <td>${estadoBadge}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" onclick="editarProceso(${proceso.id_sancion})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarProceso(${proceso.id_sancion})">
                                <i class="fas fa-trash"></i>
                            </button>
                            ${enviarBoton}
                        </div>
                    </td>
                </tr>
            `;
            
            tabla.append(fila);
        });
    }

    /**
     * Formatea una fecha en formato YYYY-MM-DD a DD/MM/YYYY
     */
    function formatearFecha(fecha) {
        if (!fecha) return '';
        
        const partes = fecha.split('-');
        if (partes.length !== 3) return fecha;
        
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }

    /**
     * Muestra una alerta en la parte superior de la página
     */
    function mostrarAlerta(tipo, mensaje) {
        const alertaHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        const contenedor = $('.container-fluid').first();
        contenedor.prepend(alertaHTML);
        
        // Auto-cerrar después de 5 segundos
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    }

    /**
     * Genera un PDF de la resolución
     */
    function generarPDF() {
        // Implementar generación de PDF
        alert('Funcionalidad de generación de PDF en desarrollo');
    }

    // Filtros
    $('#departamentoSelect').change(function() {
        filtrarPorDepartamento($(this).val());
    });

    $('#calificacionSelect').change(function() {
        filtrarPorCalificacion($(this).val());
    });
    
    // Inicializar Select2 con datos dinámicos
    $('.select2-docentes').select2({
        placeholder: 'Buscar docente...',
        allowClear: true,
        data: docentes.map(d => ({
            id: d.id,
            text: `${d.nombre} ${d.apellido} - ${d.asignatura} (${d.calificacion})`
        })),
        matcher: function (params, data) {
            // Si no hay término de búsqueda, devolver todos los elementos
            if (!params.term) {
                return data;
            }

            // Convertir término de búsqueda a minúsculas para comparación insensible a mayúsculas
            const term = params.term.toLowerCase();

            // Verificar si el texto del elemento contiene el término de búsqueda
            if (data.text.toLowerCase().indexOf(term) > -1) {
                return data;
            }

            // Si no hay coincidencia, devolver null
            return null;
        }
    });

    // Evento para el cambio de docente en el selector
    $('#docenteSelect').on('change', function () {
        const docenteId = $(this).val();
        if (docenteId) {
            cargarDatosDocente(docenteId);
        } else {
            limpiarFormulario();
        }
    });

    // Función para filtrar docentes según departamento y rango de calificación
    function filtrarDocentes() {
        const departamento = document.getElementById('departamentoSelect').value;
        const calificacionRango = document.getElementById('calificacionSelect').value;

        // Filtrar docentes
        let docentesFiltrados = [...docentes];

        if (departamento) {
            const deptoMap = {
                '1': 'Ciencias Exactas',
                '2': 'Ingeniería',
                '3': 'Humanidades'
            };
            docentesFiltrados = docentesFiltrados.filter(d => d.departamento === deptoMap[departamento]);
        }

        if (calificacionRango) {
            const rangoMap = {
                '1': { min: 0, max: 3.0 },
                '2': { min: 3.0, max: 3.5 },
                '3': { min: 3.5, max: 4.0 }
            };
            const rango = rangoMap[calificacionRango];
            docentesFiltrados = docentesFiltrados.filter(d =>
                d.calificacion >= rango.min && d.calificacion < rango.max
            );
        }

        // Actualizar Select2 con los datos filtrados
        const $select = $('#docenteSelect');

        // Destruir la instancia anterior de Select2
        $select.select2('destroy');

        // Limpiar opciones existentes
        $select.empty();

        // Agregar opción por defecto
        $select.append('<option value="">Seleccione un docente</option>');

        // Reinicializar Select2 con los datos filtrados
        $select.select2({
            placeholder: 'Buscar docente...',
            allowClear: true,
            data: docentesFiltrados.map(d => ({
                id: d.id,
                text: `${d.nombre} ${d.apellido} - ${d.asignatura} (${d.calificacion})`
            })),
            matcher: function (params, data) {
                // Si no hay término de búsqueda, devolver todos los elementos
                if (!params.term) {
                    return data;
                }

                // Convertir término de búsqueda a minúsculas para comparación insensible a mayúsculas
                const term = params.term.toLowerCase();

                // Verificar si el texto del elemento contiene el término de búsqueda
                if (data.text.toLowerCase().indexOf(term) > -1) {
                    return data;
                }

                // Si no hay coincidencia, devolver null
                return null;
            }
        });

        // Si hay docentes filtrados, seleccionar automáticamente el primero y cargar sus datos
        if (docentesFiltrados.length > 0) {
            // Seleccionar el primer docente de la lista filtrada
            $select.val(docentesFiltrados[0].id).trigger('change');
            // Cargar los datos del docente seleccionado
            cargarDatosDocente(docentesFiltrados[0].id);
        } else {
            // Si no hay docentes que coincidan con los filtros, limpiar el formulario
            limpiarFormulario();
        }
    }

    // Función para limpiar el formulario cuando no hay docentes seleccionados
    function limpiarFormulario() {
        // Limpiar campos del formulario
        document.getElementById('numeroResolucion').value = '';
        document.getElementById('fechaEmision').value = '';
        document.getElementById('nombreDocente').value = '';
        document.getElementById('apellidoDocente').value = '';
        document.getElementById('identificacionDocente').value = '';
        document.getElementById('asignaturaDocente').value = '';
        document.getElementById('calificacionDocente').value = '';
        document.getElementById('tipoSancionSelect').value = '';

        // Limpiar calificación
        const calificacionInput = document.getElementById('calificacionDocente');
        if (calificacionInput) {
            calificacionInput.value = '';
            calificacionInput.style.color = '';
            calificacionInput.style.fontWeight = '';
        }

        // Limpiar los editores Summernote
        $('#antecedentes').summernote('code', 'Describa aquí los antecedentes y el historial de evaluaciones del docente que justifican esta sanción...');
        $('#fundamentos').summernote('code', 'Especifique aquí los reglamentos, estatutos y normativas institucionales que fundamentan esta decisión...');
        $('#resolucion').summernote('code', 'Detalle aquí la resolución específica y las medidas disciplinarias adoptadas...');
    }

    // Eventos para los filtros
    const departamentoSelect = document.getElementById('departamentoSelect');
    const calificacionSelect = document.getElementById('calificacionSelect');

    if (departamentoSelect && calificacionSelect) {
        departamentoSelect.addEventListener('change', filtrarDocentes);
        calificacionSelect.addEventListener('change', filtrarDocentes);
    }

    // Verificar si hay un ID de docente en localStorage (redirigido desde alertas)
    const docenteProcesoId = localStorage.getItem('docenteProcesoId');
    if (docenteProcesoId) {
        // Seleccionar el docente en el select
        $('#docenteSelect').val(docenteProcesoId).trigger('change');
        
        // Cargar los datos del docente
        cargarDatosDocente(docenteProcesoId);
        
        // Limpiar el localStorage para no cargar automáticamente en futuras visitas
        localStorage.removeItem('docenteProcesoId');
    }
});