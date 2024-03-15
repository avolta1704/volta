//fecha limite por mes de pago de cronogra pago para el select del calendario y mes de pago

// Declaración de variable global
var dataAdAlumCronoPago;

$(".dataTableAdmisionAlumnos").on(
  "click",
  ".btnVisualizarAdmisionAlumno",
  function () {
    var codAdAlumCalendario = $(this).attr("codAdAlumCalendario");
    var data = new FormData();
    data.append("codAdAlumCalendario", codAdAlumCalendario);

    $.ajax({
      url: "ajax/admisionAlumnos.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Limpieza de la variable global
        dataAdAlumCronoPago = [];
        // Asignación de valores a la variable global
        dataAdAlumCronoPago = response;
        // Imprimir los dataAdAlumCronoPago en la consola
        console.log(dataAdAlumCronoPago);
        // Generación de los botones
        //showMonths(datos);




        
      },

      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
);


function generate_year_range(start, end) {
  var years = "";
  for (var year = start; year <= end; year++) {
    years += "<option value='" + year + "'>" + year + "</option>";
  }
  return years;
}

today = new Date();
currentMonth = today.getMonth();
currentYear = today.getFullYear();
selectYear = document.getElementById("year");
selectMonth = document.getElementById("month");

createYear = generate_year_range(1999, 2100);
/** or
 * createYear = generate_year_range( 1970, currentYear );
 */

document.getElementById("year").innerHTML = createYear;

var calendar = document.getElementById("calendar");
var lang = calendar.getAttribute("data-lang");

var months = "";
var days = "";

var monthDefault = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

var dayDefault = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];

if (lang == "en") {
  months = monthDefault;
  days = dayDefault;
} else if (lang == "id") {
  months = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];
  days = ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
} else if (lang == "fr") {
  months = [
    "Janvier",
    "Février",
    "Mars",
    "Avril",
    "Mai",
    "Juin",
    "Juillet",
    "Août",
    "Septembre",
    "Octobre",
    "Novembre",
    "Décembre",
  ];
  days = [
    "dimanche",
    "lundi",
    "mardi",
    "mercredi",
    "jeudi",
    "vendredi",
    "samedi",
  ];
} else {
  months = monthDefault;
  days = dayDefault;
}

var $dataHead = "<tr>";
for (dhead in days) {
  $dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + "</th>";
}
$dataHead += "</tr>";

//alert($dataHead);
document.getElementById("thead-month").innerHTML = $dataHead;

monthAndYear = document.getElementById("monthAndYear");
showCalendar(currentMonth, currentYear);

function next() {
  currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;
  showCalendar(currentMonth, currentYear);
}

function previous() {
  currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
  currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
  showCalendar(currentMonth, currentYear);
}

function jump() {
  currentYear = parseInt(selectYear.value);
  currentMonth = parseInt(selectMonth.value);
  showCalendar(currentMonth, currentYear);
}

function showCalendar(month, year) {
  var firstDay = new Date(year, month).getDay();

  tbl = document.getElementById("calendar-body");

  tbl.innerHTML = "";

  monthAndYear.innerHTML = months[month] + " " + year;
  selectYear.value = year;
  selectMonth.value = month;

  // creating all cells
  var date = 1;
  for (var i = 0; i < 6; i++) {
    var row = document.createElement("tr");

    for (var j = 0; j < 7; j++) {
      if (i === 0 && j < firstDay) {
        cell = document.createElement("td");
        cellText = document.createTextNode("");
        cell.appendChild(cellText);
        row.appendChild(cell);
      } else if (date > daysInMonth(month, year)) {
        break;
      } else {
        cell = document.createElement("td");
        cell.setAttribute("data-date", date);
        cell.setAttribute("data-month", month + 1);
        cell.setAttribute("data-year", year);
        cell.setAttribute("data-month_name", months[month]);
        cell.className = "date-picker";
        cell.innerHTML = "<span>" + date + "</span>";

        if (
          date === today.getDate() &&
          year === today.getFullYear() &&
          month === today.getMonth()
        ) {
          cell.className = "date-picker selected";
        }
        row.appendChild(cell);
        date++;
      }
    }

    tbl.appendChild(row);
  }
}

function daysInMonth(iMonth, iYear) {
  return 32 - new Date(iYear, iMonth, 32).getDate();
}
//funciones de meses
// Definir la variable viewingMonth en el alcance global

var viewingMonth = false;

function toggleView() {
  var calendarView = document.getElementById("calendar");
  var monthView = document.getElementById("monthView");
  var containerCalendar = document.querySelector(".container-calendar");

  if (viewingMonth) {
    // Muestra la vista de calendario y oculta la vista de meses
    calendarView.style.display = "block";
    monthView.style.display = "none";
    containerCalendar.style.display = "block"; // Muestra el div container-calendar
    viewingMonth = false;
    applyStyles();
  } else {
    // Muestra la vista de meses y oculta la vista de calendario
    calendarView.style.display = "none";
    monthView.style.display = "block";
    containerCalendar.style.display = "none"; // Oculta el div container-calendar
    viewingMonth = true;
    showMonths(); // Llama a la función showMonths para mostrar los meses
  }
}

toggleView(); // Llama a la función toggleView para cambiar a la vista de meses

// Resto del código...

//datos que contiene el dataAdAlumCronoPago variable global
//conceptoPago=string,montoPago=string,fechaLimite=date,estadoCronograma=int,mesPago=string
function showMonths() {
  var container = document.getElementById("month-body");
  container.innerHTML = "";

  // Establece el año actual en el elemento h3
  var anioEscolar = document.getElementById("anioEscolar");
  anioEscolar.innerText = "Año Escolar " + new Date().getFullYear();

  for (var i = 0; i < months.length; i++) {
    var button = document.createElement("button");
    button.setAttribute("data-month", i);
    button.className = "btn btn-outline-secondary month-picker"; // Agrega las clases btn y btn-outline-secondary
    button.innerText = months[i];

    // Agrega un evento click a cada botón de mes
    button.addEventListener("click", function () {
      var month = this.getAttribute("data-month"); // Obtiene el mes del atributo data-month
      jumpToMonth(month); // Llama a la función jumpToMonth con el mes seleccionado
    });

    container.appendChild(button);

    // Cada 3 meses, agrega un salto de línea
    if ((i + 1) % 3 === 0) {
      container.appendChild(document.createElement("br"));
    }
  }
}
/* function showMonths(dataAdAlumCronoPago) {
    var container = document.getElementById("month-body");
    container.innerHTML = "";

    // Establece el año actual en el elemento h3
    var anioEscolar = document.getElementById("anioEscolar");
    anioEscolar.innerText = "Año Escolar " + new Date().getFullYear();

    for (var i = 0; i < dataAdAlumCronoPago.length; i++) {
        var button = document.createElement("button");
        button.setAttribute("data-month", i);
        button.innerText = dataAdAlumCronoPago[i].mesPago;

        // Agrega un evento click a cada botón de mes
        button.addEventListener("click", function () {
            var month = this.getAttribute("data-month"); // Obtiene el mes del atributo data-month
            jumpToMonth(month); // Llama a la función jumpToMonth con el mes seleccionado
        });

        // Obtiene el registro correspondiente al mes actual
        var registro = dataAdAlumCronoPago[i]; 

        // Establece el estilo del botón dependiendo del estado del registro
        if (registro.estadoCronograma == 1) {
            button.className = "btn btn-outline-warning month-picker"; // Estado pendiente
        } else if (registro.estadoCronograma == 2) {
            button.className = "btn btn-outline-success month-picker"; // Estado pagado
        } else if (registro.estadoCronograma == 3) {
            button.className = "btn btn-outline-danger month-picker"; // Estado anulado
        }

        container.appendChild(button);

        // Cada 3 meses, agrega un salto de línea
        if ((i + 1) % 3 === 0) {
            container.appendChild(document.createElement("br"));
        }
    }
} */
document
  .getElementById("calendar-body")
  .addEventListener("click", function (e) {
    if (e.target.className === "month-picker") {
      currentMonth = parseInt(e.target.getAttribute("data-month"));
      showCalendar(currentMonth, currentYear);
    }
  });
function jumpToMonth(month) {
  currentMonth = parseInt(month);
  showCalendar(currentMonth, currentYear);
  toggleView(); // Cambia la vista al calendario
}
