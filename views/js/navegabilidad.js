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

	// Obtener la ruta actual desde la URL o la ruta base si no hay parámetros
	var urlParams = getUrlParams();
	var rutaActual = getUrlParameter("ruta") || urlParams.ruta;

	var routeMappings = [
		{ rutaBase: "inicio" },

		{
			rutaBase: "listaPostulantes",
			subRutas: [
				{ nombre: "nuevoPostulante" },
				{ nombre: "visualizarPostulante" },
				{ nombre: "editarPostulante" },
				{ nombre: "registrarPago", parametros: ["codPostulante"] },
			],
		},

		{
			rutaBase: "listaAdmisionAlumnos",
			subRutas: [
				{ nombre: "visualizarMatriculado" },
				{
					nombre: "editarAlumno",
					parametros: ["codAlumnoEditar", "tipo"],
				},
			],
		},

		{ rutaBase: "buscarAlumno" },

		{
			rutaBase: "listaPagos",
			subRutas: [{ nombre: "registrarPago" }, { nombre: "editarPago" }],
		},

		{ rutaBase: "listaComunicadoPago" },
		{
			rutaBase: "reportePagos",
			subRutas: [
				{ nombre: "registrarPago", parametros: ["ReportePensiones"] },
				{ nombre: "registrarComunicadoPago" },
			],
		},
		{ rutaBase: "reporteComunicaciones" },
		{ rutaBase: "listaPostulantesAnio" },
		{ rutaBase: "reporteAdmisiones" },
		{
			rutaBase: "listaAlumnos",
			subRutas: [
				{ nombre: "editarAlumno", parametros: ["codAlumnoEditar"] },
			],
		},
		{ rutaBase: "personal", subRutas: [{ nombre: "editarPersonal" }] },
		{ rutaBase: "usuarios" },
		{ rutaBase: "apoderado", subRutas: [{ nombre: "editarApoderado" }] },
		{ rutaBase: "cursos" },
		{ rutaBase: "asignarCursos" },
		{
			rutaBase: "cursosDocente",
			subRutas: [
				{ nombre: "notasCursoDocente" },
				{ nombre: "registrarNotas" },
				{ nombre: "visualizarAsistencia" },
			],
		},
	];

	function findBaseRoute(route, params) {
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

				// Verificamos si la subruta tiene parámetros
				if (!parametrosSubRuta) {
					if (nombreSubRuta === route) {
						return baseRoute;
					}
				}

				// Verificar si la subruta coincide y tiene los parámetros requeridos
				if (nombreSubRuta === route) {
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
		return null;
	}

	var activeRoute = findBaseRoute(rutaActual, urlParams.parametros);

	// Selecciona todos los enlaces del menú
	var menuItems = document.querySelectorAll(
		"#sidebar-nav a.nav-link, #sidebar-nav .nav-content a"
	);

	// Recorre todos los elementos del menú
	menuItems.forEach(function (menuItem) {
		// Obtén el href del elemento del menú
		var menuItemHref = menuItem.getAttribute("href");

		// Verifica si el href del elemento coincide con la URL actual
		if (
			menuItemHref === rutaActual ||
			(activeRoute && menuItemHref === activeRoute)
		) {
			// Añade la clase 'active' al elemento del menú
			menuItem.classList.add("active");

			// Si el elemento del menú está dentro de un submenú, también abre el submenú
			var parentCollapse = menuItem.closest(".collapse");
			if (parentCollapse) {
				var parentLink = parentCollapse.previousElementSibling;
				parentCollapse.classList.add("show");
				parentLink.classList.remove("collapsed");
			}
		}
	});
});
