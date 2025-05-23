document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Summernote
    if ($.fn.summernote) {
        $('#summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Aquí el decano hará sus comentarios hacia el respectivo docente...'
        });
    }

    // Inicializar Select2
    if ($.fn.select2) {
        $('.select2-docentes').select2({
            placeholder: 'Buscar docente...',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            },
            ajax: {
                url: routeUrl('actas.filtrar'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '',
                        departamento: $('#departamentoSelect').val(),
                        calificacion: $('#calificacionSelect').val(),
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return data; // La respuesta ya viene formateada correctamente
                },
                cache: true
            },
            minimumInputLength: 0
        });
    }

    // Manejar evento de cambio en los filtros
    $('#departamentoSelect, #calificacionSelect').on('change', function() {
        // Limpiar la selección actual
        $('.select2-docentes').val(null).trigger('change');

        // Recargar los datos (forzar una nueva búsqueda)
        $('.select2-docentes').select2('open');
        $('.select2-docentes').select2('close');
    });

    // Manejar evento de selección de docente
    $('#docenteSelect').on('change', function () {
        const docenteId = $(this).val();
        if (docenteId) {
            cargarDatosDocente(docenteId);
        } else {
            inicializarFormularioVacio();
        }
    });

    // Inicializar manejo de firma
    inicializarManejoDeFirma();

    // Inicializar formulario vacío al cargar la página
    inicializarFormularioVacio();

    // Manejar el envío del formulario
    $('#enviar-reporte-btn').on('click', function() {
        enviarReporte();
    });
});

// Función auxiliar para obtener URLs de rutas Laravel
function routeUrl(name, parameters = {}) {
    // Si estás usando el plugin ziggy
    if (typeof route === 'function') {
        return route(name, parameters);
    }

    // Si estás usando rutas definidas en Laravel sin el plugin ziggy
    const routes = {
        'actas.filtrar': '/actas/filtrar',
        'actas.docente': '/actas/docente/'
    };

    if (name === 'actas.docente' && parameters.id) {
        return routes[name] + parameters.id;
    }

    return routes[name];
}

// Función para cargar datos del docente
function cargarDatosDocente(id) {
    // Mostrar indicador de carga (opcional)
    const formContainer = document.querySelector('.card-body');
    if (formContainer) {
        formContainer.classList.add('loading');
    }

    fetch(routeUrl('actas.docente', { id: id }))
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener datos del docente');
            }
            return response.json();
        })
        .then(docente => {
            console.log('Datos del docente:', docente); // Debugging

            // Actualizar campo oculto con el ID del docente
            document.getElementById('docente_id').value = docente.id;

            // Buscar todos los inputs en el formulario por su nombre
            const numActaInput = document.querySelector('input[name="numero_acta"]');
            const fechaActaInput = document.querySelector('input[name="fecha_acta"]');
            const nombreInput = document.querySelector('input[name="nombre"]');
            const apellidoInput = document.querySelector('input[name="apellido"]');
            const identificacionInput = document.querySelector('input[name="identificacion"]');
            const asignaturaInput = document.querySelector('input[name="asignatura"]');
            const calificacionInput = document.querySelector('input[name="calificacion"]');
            const departamentoInput = document.querySelector('input[name="departamento"]');

            // Actualizar los campos con los datos del docente
            if (numActaInput) numActaInput.value = generarNumeroActa();
            if (fechaActaInput) fechaActaInput.value = establecerFechaActual();
            if (nombreInput) nombreInput.value = docente.nombre;
            if (apellidoInput) apellidoInput.value = docente.apellido;
            if (identificacionInput) identificacionInput.value = docente.identificacion;
            if (asignaturaInput) asignaturaInput.value = docente.asignatura;
            if (departamentoInput) departamentoInput.value = docente.departamento;

            // Actualizar calificación con formato y estilo
            if (calificacionInput) {
                calificacionInput.value = docente.calificacion.toFixed(1);

                // Aplicar estilo según calificación
                if (docente.calificacion < 3.0) {
                    calificacionInput.style.color = '#dc3545'; // Rojo para calificaciones muy bajas
                    calificacionInput.style.fontWeight = 'bold';
                } else if (docente.calificacion < 3.5) {
                    calificacionInput.style.color = '#fd7e14'; // Naranja para calificaciones bajas
                    calificacionInput.style.fontWeight = 'bold';
                } else {
                    calificacionInput.style.color = '#ffc107'; // Amarillo para calificaciones cercanas a 4
                    calificacionInput.style.fontWeight = 'bold';
                }
            }

            // Actualizar el contenido del editor Summernote con un mensaje personalizado
            const summernote = $('#summernote');
            if (summernote.length && $.fn.summernote) {
                const mensaje = `
                    <p>Retroalimentación para el docente <strong>${docente.nombre} ${docente.apellido}</strong> de la asignatura <strong>${docente.asignatura}</strong>.</p>
                    <p>La calificación obtenida fue de <strong>${docente.calificacion.toFixed(1)}</strong>, lo cual está por debajo del umbral esperado de 4.0.</p>
                    <p>Tras revisar su desempeño, se han identificado las siguientes oportunidades de mejora:</p>
                    <ul>
                        <li>Punto 1: [Agregue sus observaciones]</li>
                        <li>Punto 2: [Agregue sus observaciones]</li>
                        <li>Punto 3: [Agregue sus observaciones]</li>
                    </ul>
                    <p>Plan de acción recomendado:</p>
                    <ol>
                        <li>Acción 1: [Detalle la acción]</li>
                        <li>Acción 2: [Detalle la acción]</li>
                        <li>Acción 3: [Detalle la acción]</li>
                    </ol>
                    <p>Fecha límite para implementar mejoras: [DD/MM/AAAA]</p>
                `;
                summernote.summernote('code', mensaje);
            }

            // Quitar indicador de carga (opcional)
            if (formContainer) {
                formContainer.classList.remove('loading');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('No se pudo cargar la información del docente. Por favor, intente nuevamente.');

            // Quitar indicador de carga (opcional)
            if (formContainer) {
                formContainer.classList.remove('loading');
            }
        });
}

// Función para inicializar el formulario vacío
function inicializarFormularioVacio() {
    // Limpiar el ID del docente
    document.getElementById('docente_id').value = '';

    // Buscar todos los inputs en el formulario y limpiarlos
    const formInputs = document.querySelectorAll('.form-acta input.form-control');
    formInputs.forEach(input => {
        input.value = '';

        // Resetear estilos para el campo de calificación
        if (input.classList.contains('calificacion-baja')) {
            input.style.color = '';
            input.style.fontWeight = '';
        }
    });

    // Limpiar el editor Summernote
    const summernote = $('#summernote');
    if (summernote.length && $.fn.summernote) {
        summernote.summernote('code', '');
    }
}

// Generar número de acta aleatorio
function generarNumeroActa() {
    const prefix = 'ACT';
    const timestamp = new Date().getTime().toString().slice(-6);
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    return `${prefix}-${timestamp}-${random}`;
}

// Establecer fecha actual
function establecerFechaActual() {
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2, '0');
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const anio = hoy.getFullYear();
    return `${dia}/${mes}/${anio}`;
}

// Función para inicializar el manejo de la firma digital
function inicializarManejoDeFirma() {
    const seleccionarFirmaBtn = document.getElementById('seleccionar-firma');
    const eliminarFirmaBtn = document.getElementById('eliminar-firma');
    const firmaInput = document.getElementById('firma-input');
    const firmaPreview = document.getElementById('firma-preview');
    const firmaImagen = document.getElementById('firma-imagen');
    const firmaPlaceholder = document.getElementById('firma-placeholder');

    if (!seleccionarFirmaBtn || !firmaInput) return;

    // Evento para el botón de seleccionar firma
    seleccionarFirmaBtn.addEventListener('click', function (e) {
        e.preventDefault(); // Prevenir comportamiento por defecto
        firmaInput.click();
    });

    // Evento para cuando se selecciona un archivo
    firmaInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Verificar que sea una imagen PNG o JPG
            if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                alert('Por favor, seleccione una imagen en formato PNG o JPG.');
                this.value = '';
                return;
            }

            // Verificar tamaño del archivo (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('El archivo es demasiado grande. Por favor, seleccione una imagen de menos de 2MB.');
                this.value = '';
                return;
            }

            // Mostrar vista previa de la imagen
            const reader = new FileReader();
            reader.onload = function (e) {
                firmaImagen.src = e.target.result;
                firmaPreview.classList.remove('d-none');
                firmaPlaceholder.classList.add('d-none');
                eliminarFirmaBtn.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Evento para el botón de eliminar firma
    if (eliminarFirmaBtn) {
        eliminarFirmaBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevenir comportamiento por defecto
            firmaInput.value = '';
            firmaImagen.src = '#';
            firmaPreview.classList.add('d-none');
            firmaPlaceholder.classList.remove('d-none');
            eliminarFirmaBtn.classList.add('d-none');
        });
    }
}

// Función para enviar reporte
function enviarReporte() {
    // Verificar que haya un docente seleccionado
    const docenteId = document.getElementById('docente_id').value;
    if (!docenteId) {
        alert('Por favor, seleccione un docente antes de enviar el reporte.');
        return;
    }

    // Verificar que haya una firma cargada
    const firmaPreview = document.getElementById('firma-preview');
    if (firmaPreview.classList.contains('d-none')) {
        alert('Por favor, cargue la firma del decano antes de enviar el reporte.');
        return;
    }

    // Verificar que haya contenido en la retroalimentación
    const summernote = $('#summernote');
    if (summernote.length && $.fn.summernote) {
        const contenido = summernote.summernote('code');
        if (!contenido || contenido.trim() === '') {
            alert('Por favor, complete la retroalimentación y plan de mejora antes de enviar.');
            return;
        }
    }

    // Confirmar el envío
    if (confirm('¿Está seguro de enviar el acta de compromiso al docente?')) {
        // Enviar el formulario
        document.getElementById('formActa').submit();
    }
}
