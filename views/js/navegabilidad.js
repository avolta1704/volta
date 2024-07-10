document.addEventListener("DOMContentLoaded", function () {
	function getUrlParameter(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
		var results = regex.exec(location.search);
		return results === null
			? ""
			: decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function getUrlParams() {
		var params = {};
		var url = location.href;
		var urlParts = url.split("?");
		if (urlParts.length > 1) {
			// Obtener la ruta desde la URL
			var rutaParts = urlParts[0].split("/");
			var ruta = rutaParts[rutaParts.length - 1];

			// Obtener los parámetros desde la URL
			var paramsParts = urlParts[1].split("&");
			for (var i = 0; i < paramsParts.length; i++) {
				var param = paramsParts[i].split("=");
				params[param[0]] = param[1]; // Corregido para asignar el valor correctamente
			}
		} else {
			var rutaParts = url.split("/");
			var ruta = rutaParts[rutaParts.length - 1];
		}

		// Crear un arreglo con los nombres de los parámetros
		var paramNames = Object.keys(params);

		return {
			ruta: ruta,
			parametros: paramNames,
		};
	}

	// Función para obtener el tipo de usuario mediante AJAX
	function obtenerTipoUsuario(callback) {
		var data = new FormData();
		data.append("tieneAcceso", true);

		$.ajax({
			url: "ajax/usuarios.ajax.php", // Reemplaza con la URL correcta de tu archivo AJAX
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				if (typeof callback === "function") {
					callback(response); // Llama al callback con el tipo de usuario
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText); // procedencia de error
				console.log(
					"Error en la solicitud AJAX: ",
					textStatus,
					errorThrown
				);
			},
		});
	}

	// Obtener la ruta actual desde la URL o la ruta base si no hay parámetros
	var urlParams = getUrlParams();
	var rutaActual = getUrlParameter("ruta") || urlParams.ruta;

	var routeMappings = [
		{
			rutaBase: "inicio",
			acceso: [
				"administrador",
				"docente",
				"administrativo",
				"apoderado",
				"dirección",
			], // Ejemplo de acceso permitido para varios tipos de usuario
		},

		{
			rutaBase: "listaPostulantes",
			acceso: ["administrador", "administrativo"],
			subRutas: [
				{
					nombre: "nuevoPostulante",
					acceso: ["administrador", "administrativo"],
				},
				{
					nombre: "visualizarPostulante",
					acceso: ["administrador", "administrativo"],
				},
				{
					nombre: "editarPostulante",
					acceso: ["administrador", "administrativo"],
				},
				{
					nombre: "registrarPago",
					parametros: ["codPostulante"],
					acceso: ["administrador", "administrativo"],
				},
			],
		},

		{
			rutaBase: "buscarPostulante",
			acceso: ["administrador", "administrativo"],
		},

		{
			rutaBase: "listaAdmisionAlumnos",
			acceso: ["administrador", "dirección", "administrativo"],
			subRutas: [
				{
					nombre: "visualizarMatriculado",
					acceso: ["administrador", "dirección"],
				},
				{
					nombre: "editarAlumno",
					parametros: ["codAlumnoEditar", "tipo"],
					acceso: ["administrador", "dirección"],
				},
			],
		},

		{
			rutaBase: "buscarAlumno",
			acceso: ["administrador", "dirección", "docente", "administrativo"],
		},

		{
			rutaBase: "tecnicaseInstrumentos",
			acceso: ["administrador", "dirección"],
		},

		{
			rutaBase: "perfil",
			acceso: ["administrador", "dirección", "docente", "administrativo"],
		},

		{
			rutaBase: "listaComunicadoPago",
			acceso: ["administrador", "dirección", "docente", "administrativo"],
		},

		{
			rutaBase: "reportePagos",
			acceso: ["administrador", "dirección", "administrativo"],
			subRutas: [
				{
					nombre: "registrarComunicadoPago",
					acceso: ["administrador", "dirección"],
				},
				{
					nombre: "registrarPago",
					parametros: ["ReportePensiones"],
					acceso: ["administrador", "dirección", "administrativo"],
				},
			],
		},
		{
			rutaBase: "reporteComunicaciones",
			acceso: ["administrador", "dirección", "administrativo"],
		},
		{
			rutaBase: "reporteSegimiento", // TODO cambiar a seguimiento
			acceso: ["administrador", "dirección"],
		},
		{
			rutaBase: "reporteNotas",
			acceso: ["administrador", "dirección", "docente"],
		},
		{
			rutaBase: "reporteAsistencias",
			acceso: ["administrador", "dirección", "docente"],
		},
		{
			rutaBase: "listaPostulantesAnio",
			acceso: ["administrador", "dirección", "docente", "administrativo"],
		},
		{
			rutaBase: "reporteAdmisiones",
			acceso: ["administrador", "dirección", "administrativo"],
		},
		{
			rutaBase: "listaAlumnos",
			acceso: ["administrador", "dirección", "docente"],
			subRutas: [
				{
					nombre: "editarAlumno",
					parametros: ["codAlumnoEditar"],
					acceso: ["administrador", "dirección", "docente"],
				},
			],
		},
		{
			rutaBase: "personal",
			acceso: ["administrador", "dirección"],
			subRutas: [
				{
					nombre: "editarPersonal",
					acceso: ["administrador", "dirección"],
				},
			],
		},
		{ rutaBase: "usuarios", acceso: ["administrador", "dirección"] },
		{
			rutaBase: "apoderado",
			acceso: ["administrador", "dirección"],
			subRutas: [
				{
					nombre: "editarApoderado",
					acceso: ["administrador", "dirección"],
				},
			],
		},
		{
			rutaBase: "cursos",
			acceso: ["administrador", "dirección"],
		},
		{
			rutaBase: "asignarCursos",
			acceso: ["administrador", "dirección", "docente"],
		},
		{
			rutaBase: "cursosDocente",
			acceso: ["docente"],
			subRutas: [
				{ nombre: "notasCursoDocente", acceso: ["docente"] },
				{ nombre: "registrarNotas", acceso: ["docente"] },
				{ nombre: "visualizarAsistencia", acceso: ["docente"] },
			],
		},
		{
			rutaBase: "listaDocentes",
			acceso: ["administrador", "dirección"],
		},
		{
			rutaBase: "seguimientoDocentes",
			acceso: ["administrador", "dirección"],
		},
		{
			rutaBase: "anioEscolar",
			acceso: ["administrador", "administrativo"],
			subRutas: [
				{nombre:"cerrarAnioGrado", acceso:["administrador"]},
			],
		},
		{
			rutaBase: "asistencia",
			acceso: ["docente"],
		},
		{
			rutaBase: "notas",
			acceso: ["docente"],
		},
		{
			rutaBase: "listaPagos",
			acceso: ["administrador", "dirección", "administrativo"],
			subRutas: [
				{
					nombre: "registrarPago",
					acceso: ["administrador", "dirección", "administrativo"],
				},
				{
					nombre: "editarPago",
					acceso: ["administrador", "dirección", "administrativo"],
				},
			],
		},
		{
			rutaBase: "notasApoderado",
			acceso: ["apoderado"],
		},
		{
			rutaBase: "asistenciaApoderado",
			acceso: ["apoderado"],
		},
		{
			rutaBase: "listaAlumnosDocentes",
			acceso: ["docente"],
		},
		{
			rutaBase: "asistenciaAlumnosDocentes",
			acceso: ["docente"],
		},
		{
			rutaBase: "notasAlumnoDocente",
			acceso: ["docente"],
		}
	];

	// Función para encontrar la ruta base activa
	function findBaseRoute(route, params, tipoUsuario) {
		for (var i = 0; i < routeMappings.length; i++) {
			var baseRoute = routeMappings[i].rutaBase;
			var subRutas = routeMappings[i].subRutas || [];

			if (baseRoute === route) {
				return baseRoute;
			}

			for (var j = 0; j < subRutas.length; j++) {
				var subRuta = subRutas[j];
				var nombreSubRuta =
					typeof subRuta === "object" ? subRuta.nombre : subRuta;
				var parametrosSubRuta =
					typeof subRuta === "object" ? subRuta.parametros : [];
				var accesoSubRuta =
					typeof subRuta === "object" && subRuta.acceso
						? subRuta.acceso
						: [];

				if (!parametrosSubRuta) {
					if (nombreSubRuta === route) {
						return baseRoute;
					}
				}

				// Verificar si la subruta coincide y tiene los roles requeridos
				if (nombreSubRuta === route) {
					var accesoValido = true;
					if (accesoSubRuta.length > 0) {
						accesoValido = false;
						if (accesoSubRuta.includes(tipoUsuario)) {
							accesoValido = true;
						}
					}

					// Verificar si la subruta tiene los parámetros requeridos
					if (accesoValido) {
						var parametrosValidos = true;
						for (var k = 0; k < parametrosSubRuta.length; k++) {
							if (!params.includes(parametrosSubRuta[k])) {
								parametrosValidos = false;
								break;
							}
						}
						if (parametrosValidos) {
							return baseRoute;
						}
					}
				}
			}
		}
		return null;
	}

	// Obtener tipo de usuario y procesar las rutas permitidas
	obtenerTipoUsuario(function (tipoUsuario) {
		// Filtrar las rutas permitidas según el tipo de usuario
		var rutasPermitidas = routeMappings.filter(function (ruta) {
			// Si la ruta no tiene restricciones de acceso, es permitida por defecto
			if (!ruta.acceso) {
				return true;
			}

			// Verificar si el tipo de usuario tiene acceso a esta ruta
			if (ruta.acceso.includes(tipoUsuario)) {
				return true;
			}

			return false;
		});

		// Obtener la ruta actual desde la URL
		var rutaActual = getUrlParameter("ruta") || urlParams.ruta;

		// Función para encontrar la ruta base activa
		var activeRoute = findBaseRoute(
			rutaActual,
			urlParams.parametros,
			tipoUsuario
		);

		// Seleccionar todos los enlaces del menú
		var menuItems = document.querySelectorAll(
			"#sidebar-nav a.nav-link, #sidebar-nav .nav-content a"
		);

		// Recorrer todos los elementos del menú
		menuItems.forEach(function (menuItem) {
			// Obtener el href del elemento del menú
			var menuItemHref = menuItem.getAttribute("href");

			// Verificar si el href del elemento coincide con la URL actual
			if (
				menuItemHref === rutaActual ||
				(activeRoute && menuItemHref === activeRoute)
			) {
				// Añadir la clase 'active' al elemento del menú
				menuItem.classList.add("active");

				// Si el elemento del menú está dentro de un submenú, también abrir el submenú
				var parentCollapse = menuItem.closest(".collapse");
				if (parentCollapse) {
					var parentLink = parentCollapse.previousElementSibling;
					parentCollapse.classList.add("show");
					parentLink.classList.remove("collapsed");
				}
			}
		});

		// Verificar si la activeRoute esta dentro de las rutas permitidas y devolver booleano
		var activeRouteExists = rutasPermitidas.some(function (ruta) {
			return ruta.rutaBase === activeRoute;
		});

		// Verificar si la ruta actual no está permitida para el tipo de usuario y que no sea inicio
		if (!activeRouteExists && rutaActual !== "inicio") {
			// Redirigir a la página de inicio
			window.location = "index.php?ruta=inicio";
		}
	});
});
