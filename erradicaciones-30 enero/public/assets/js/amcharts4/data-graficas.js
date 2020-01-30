//PALETA DE COLORES
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function am4themes_myTheme(target) {
    if (target instanceof am4core.ColorSet) {
      target.list = [
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
        am4core.color(getRandomColor()),
      ];
    }
  }


//GRÁFICA TIPO DE PLANTIO
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
am4core.useTheme(am4themes_myTheme);

var chart = am4core.create("chartdivtipos", am4charts.PieChart3D);

chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [{
    "label": '<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>',
    "menu": [
        {
          "label": "Image",
          "menu": [
            { "type": "png", "label": "PNG" },
            { "type": "jpg", "label": "JPG" },
            { "type": "gif", "label": "GIF" },
            { "type": "svg", "label": "SVG" },
          ]
        }, {
          "label": "Data",
          "menu": [
            { "type": "json", "label": "JSON" },
            { "type": "csv", "label": "CSV" },
            { "type": "xlsx", "label": "XLSX" }
          ]
        }, {
          "label": "Print", "type": "print"
        }
      ]
  }];
chart.data = misDatos;
chart.innerRadius = am4core.percent(35);


var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "total";
series.dataFields.category = "tipo_plantio";
series.labels.template.fill = am4core.color("black");
// Set up fills
series.slices.template.fillOpacity = 1
var hs = series.slices.template.states.getKey("hover");
//hs.properties.scale = 1;
hs.properties.fillOpacity = 0.5;;
// Add and configure Series
series.labels.template.text = "{category} - {value.value} - ({value.percent.formatNumber('#.0')}%)";
chart.legend = new am4charts.Legend();

// Set up tooltips
series.tooltip.label.interactionsEnabled = true;
series.tooltip.keepTargetHover = true;
series.slices.template.tooltipHTML = '<b>Plantio: {category}<br>Total de Plantios: {value.value}<br>Porcentaje: {value.percent.formatNumber("#.0")}%</br>';
series.slices.template.stroke = am4core.color("#000000");
series.slices.template.strokeWidth = 0.5;
series.slices.template.strokeOpacity = 0.5;
series.slices.template.cornerRadius = 5;
series.colors.step = 3;


//GRÁFICA TIPO DE PRESENTACION
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdivpresentacion", am4charts.PieChart3D);

chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [{
    "label": '<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>',
    "menu": [
        {
          "label": "Image",
          "menu": [
            { "type": "png", "label": "PNG" },
            { "type": "jpg", "label": "JPG" },
            { "type": "gif", "label": "GIF" },
            { "type": "svg", "label": "SVG" },
          ]
        }, {
          "label": "Data",
          "menu": [
            { "type": "json", "label": "JSON" },
            { "type": "csv", "label": "CSV" },
            { "type": "xlsx", "label": "XLSX" }
          ]
        }, {
          "label": "Print", "type": "print"
        }
      ]
  }];
chart.data = misDatosPresentacion;
chart.innerRadius = am4core.percent(40);

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "total_presentacion";
series.dataFields.category = "tipo_presentacion";
series.labels.template.fill = am4core.color("black");
// Set up fills
series.slices.template.fillOpacity = 1
var hs = series.slices.template.states.getKey("hover");
//hs.properties.scale = 1;
hs.properties.fillOpacity = 0.5;;
// Add and configure Series
series.labels.template.text = "{category} - {value.value} - ({value.percent.formatNumber('#.0')}%)";
chart.legend = new am4charts.Legend();
// Set up tooltips
series.tooltip.label.interactionsEnabled = true;
series.tooltip.keepTargetHover = true;
series.slices.template.tooltipHTML = '<b>Plantio: {category}<br>Total de Plantios: {value.value}<br>Porcentaje: {value.percent.formatNumber("#.0")}%</br>';
series.slices.template.stroke = am4core.color("#000000");
series.slices.template.strokeWidth = 0.5;
series.slices.template.strokeOpacity = 0.5;
series.slices.template.cornerRadius = 5;
series.colors.step = 3;


//GRÁFICA AREA ERRADICADA HECTAREA
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiha", am4charts.PieChart3D);

chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [{
    "label": '<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>',
    "menu": [
        {
          "label": "Image",
          "menu": [
            { "type": "png", "label": "PNG" },
            { "type": "jpg", "label": "JPG" },
            { "type": "gif", "label": "GIF" },
            { "type": "svg", "label": "SVG" },
          ]
        }, {
          "label": "Data",
          "menu": [
            { "type": "json", "label": "JSON" },
            { "type": "csv", "label": "CSV" },
            { "type": "xlsx", "label": "XLSX" }
          ]
        }, {
          "label": "Print", "type": "print"
        }
      ]
  }];

chart.data = misDatosAreaHectarea;
chart.innerRadius = am4core.percent(40);

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "total_area_hectarea";
series.dataFields.category = "tipo_plantio_area_hectarea";
series.labels.template.fill = am4core.color("black");
// Set up fills
series.slices.template.fillOpacity = 1
var hs = series.slices.template.states.getKey("hover");
//hs.properties.scale = 1;
hs.properties.fillOpacity = 0.5;;
// Add and configure Series
series.labels.template.text = "{category} - {value.value} - ({value.percent.formatNumber('#.0')}%)";
chart.legend = new am4charts.Legend();
// Set up tooltips
series.tooltip.label.interactionsEnabled = true;
series.tooltip.keepTargetHover = true;
series.slices.template.tooltipHTML = '<b>Plantio: {category}<br>Total de Plantios: {value.value}<br>Porcentaje: {value.percent.formatNumber("#.0")}%</br>';
series.slices.template.stroke = am4core.color("#000000");
series.slices.template.strokeWidth = 0.5;
series.slices.template.strokeOpacity = 0.5;
series.slices.template.cornerRadius = 5;
series.colors.step = 3;




//GRÁFICA AREA ERRADICADA
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdivarea", am4charts.PieChart3D);

chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [{
    "label": '<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>',
    "menu": [
        {
          "label": "Image",
          "menu": [
            { "type": "png", "label": "PNG" },
            { "type": "jpg", "label": "JPG" },
            { "type": "gif", "label": "GIF" },
            { "type": "svg", "label": "SVG" },
          ]
        }, {
          "label": "Data",
          "menu": [
            { "type": "json", "label": "JSON" },
            { "type": "csv", "label": "CSV" },
            { "type": "xlsx", "label": "XLSX" }
          ]
        }, {
          "label": "Print", "type": "print"
        }
      ]
  }];

chart.data = misDatosArea;
chart.innerRadius = am4core.percent(40);

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "total_area";
series.dataFields.category = "tipo_plantio_area";
series.labels.template.fill = am4core.color("black");
// Set up fills
series.slices.template.fillOpacity = 1
var hs = series.slices.template.states.getKey("hover");
//hs.properties.scale = 1;
hs.properties.fillOpacity = 0.5;;
// Add and configure Series
series.labels.template.text = "{category} - {value.value} - ({value.percent.formatNumber('#.0')}%)";
chart.legend = new am4charts.Legend();
// Set up tooltips
series.tooltip.label.interactionsEnabled = true;
series.tooltip.keepTargetHover = true;
series.slices.template.tooltipHTML = '<b>Plantio: {category}<br>Total de Plantios: {value.value}<br>Porcentaje: {value.percent.formatNumber("#.0")}%</br>';
series.slices.template.stroke = am4core.color("#000000");
series.slices.template.strokeWidth = 0.5;
series.slices.template.strokeOpacity = 0.5;
series.slices.template.cornerRadius = 5;
series.colors.step = 3;



//GRÁFICA TIPO DE INSTITUCION
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartInstituciones", am4charts.PieChart3D);

chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [{
    "label": '<i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>',
    "menu": [
        {
          "label": "Image",
          "menu": [
            { "type": "png", "label": "PNG" },
            { "type": "jpg", "label": "JPG" },
            { "type": "gif", "label": "GIF" },
            { "type": "svg", "label": "SVG" },
          ]
        }, {
          "label": "Data",
          "menu": [
            { "type": "json", "label": "JSON" },
            { "type": "csv", "label": "CSV" },
            { "type": "xlsx", "label": "XLSX" }
          ]
        }, {
          "label": "Print", "type": "print"
        }
      ]
  }];
chart.data = misDatosInstituciones;
chart.innerRadius = am4core.percent(40);

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "total_institucion";
series.dataFields.category = "tipo_institucion";
series.labels.template.fill = am4core.color("black");
// Set up fills
series.slices.template.fillOpacity = 1
var hs = series.slices.template.states.getKey("hover");
//hs.properties.scale = 1;
hs.properties.fillOpacity = 0.5;;
// Add and configure Series
series.labels.template.text = "{category} - {value.value} - ({value.percent.formatNumber('#.0')}%)";
chart.legend = new am4charts.Legend();
// Set up tooltips
series.tooltip.label.interactionsEnabled = true;
series.tooltip.keepTargetHover = true;
series.slices.template.tooltipHTML = '<b>Plantio: {category}<br>Total de Plantios: {value.value}<br>Porcentaje: {value.percent.formatNumber("#.0")}%</br>';
series.slices.template.stroke = am4core.color("#000000");
series.slices.template.strokeWidth = 0.5;
series.slices.template.strokeOpacity = 0.5;
series.slices.template.cornerRadius = 5;
series.colors.step = 3;
