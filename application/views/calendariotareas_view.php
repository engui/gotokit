<?php

include 'includes/header.php';

?>
<div id="mycalendar"></div>
<table id="leyenda" style="width: 100%;margin-top:20px">
	<tr>
		<th width="25%"></th>
		<th width="25%"></th>
		<th width="25%"></th>
		<th width="25%"></th>
		
	</tr>
	<tr>
	<?php
		$cont = 1;
		foreach($datosUsuarios as $usuario)
		{
			if ($cont%4 == 0) 
			{
				echo '<td style="text-align: left"><div style=" background-color: '.$usuario['color_usuario'].'; display: initial;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;';
				echo $usuario['nombre'].'</td></tr>';
				/*echo '<td style="text-align: center">'.$usuario['nombre'];
				echo '<div style=" background-color: '.$usuario['color_usuario'].'; display: initial;">&nbsp;&nbsp;&nbsp;&nbsp;</div></td></tr>';*/
			}
			else
			{
				echo '<td style="text-align: left"><div style=" background-color: '.$usuario['color_usuario'].'; display: initial;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;';
				echo $usuario['nombre'].'</td>';
				/*echo '<td style="text-align: center">'.$usuario['nombre'];
				echo '<div style=" background-color: '.$usuario['color_usuario'].'; display: initial;">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>';*/
			}
			$cont++;
		}
	?>
</table>


<script type="text/javascript">
	
</script>
<script type="text/javascript">
	var datosCalendario = <?php echo json_encode($datosCalendario) ?>;
	var Super = <?php echo $this->session->userdata('super') ?>;
	var arrayEventos = [];
	
	for (var i = 0; i < datosCalendario.length; i++) 
	{
		if(Super == 1)
		{
			if(datosCalendario[i]["hora_limite"] == "00:00:00")
			{
				arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "<?php echo base_url()?>tarea/"+datosCalendario[i]["cod_tarea"] , usuarioDestino: datosCalendario[i]["usuario_destino"]})
			}
			else
			{
				arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"]+"T"+datosCalendario[i]["hora_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "<?php echo base_url()?>tarea/"+datosCalendario[i]["cod_tarea"] , usuarioDestino: datosCalendario[i]["usuario_destino"]});
			}
		}
		else
		{
			if(datosCalendario[i]["usuario_destino"] == <?php echo $this->session->userdata('cod_usuario') ?>)
			{
				if(datosCalendario[i]["hora_limite"] == "00:00:00")
				{
					arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "<?php echo base_url()?>tarea/"+datosCalendario[i]["cod_tarea"] , usuarioDestino: datosCalendario[i]["usuario_destino"]});
				}
				else
				{
					arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"]+"T"+datosCalendario[i]["hora_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "<?php echo base_url()?>tarea/"+datosCalendario[i]["cod_tarea"] , usuarioDestino: datosCalendario[i]["usuario_destino"]});
				}
			}
			else
			{
				if(datosCalendario[i]["hora_limite"] == "00:00:00")
				{
					arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "",usuarioDestino: datosCalendario[i]["usuario_destino"]});
				}
				else
				{
					arrayEventos.push({id: datosCalendario[i]["cod_tarea"] , title: datosCalendario[i]["nombre"] , start: datosCalendario[i]["fecha_limite"]+"T"+datosCalendario[i]["hora_limite"], backgroundColor: datosCalendario[i]["color_usuario"], borderColor: datosCalendario[i]["color_usuario"], url: "", usuarioDestino: datosCalendario[i]["usuario_destino"]});
				}
			}
		}	
	}
	$('#mycalendar').fullCalendar({
	themeSystem: 'bootstrap4',
	header: 
	{
	    left: '',
	    center: 'title',
	    right: 'today,prevYear,prev,next,nextYear'
  	},
  	/*customButtons: {
      myCustomButton: {
        text: 'Ir a...',
        click: function() 
        {
        	var fecha = document.getElementById("campoFecha").value; 
			var  fechaFormateada = moment(fecha, "YYYY-MM-DD");
        	$("#mycalendar").fullCalendar('gotoDate', fechaFormateada);
        }
      }
    },*/
    eventAfterRender: function(event, element) {
        $(element).tooltip({
            title: event.title,
            container: "body"
        });
    },
  	locale: 'es',
    events: arrayEventos,
    timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
    eventRender: function eventRender( event, element, view ) {
        //return ['defecto', event.usuarioDestino].indexOf($('#menuUsuarios').val()) >= 0
    }
});

$('#menuUsuarios').on('change',function(){
    $('#mycalendar').fullCalendar('rerenderEvents');
})

function buscarDia()
{
	var fecha = document.getElementById("campoFecha").value; 
	var  fechaFormateada = moment(fecha, "YYYY-MM-DD");
	$("#mycalendar").fullCalendar('gotoDate', fechaFormateada);
}
</script>

<?php

include 'includes/footer.php';

?>