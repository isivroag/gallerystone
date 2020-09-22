<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="css/estilocot.css">
</head>
<body>

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img style="width:200px;"src="img/logo.jpg">
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="empresa">GALLERY STONE</span>
					<p>Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz</p>
					<p>Teléfonos: 228-1524147 228-1179998 </p>
					<p>Email: info@gallerystone.com.mx</p>
				</div>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="encabezado">Prespuesto</span>
					<p>No. Presupuesto: <strong>000001</strong></p>
					<p>Fecha: 20/01/2019</p>
					<p>Hora: 10:30am</p>
					
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="encabezado">Cliente</span>
					<p><b>ARQ. ARTURO JIMENEZ</b> </p> 
					<p><b> PRESENTE</b></p>
					<br>
					<p style="text-align: justify">De acuerdo a su amable solicitud para el  proyecto ubicado en Fracc.  El porvenir en Xalapa , Veracruz; referente a suministro y colocación de santo tomas gris martelinado en área de alberca , medida  40x largos libres; establecemos a su consideración la siguiente cotización 
</p>

					
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle" >
			<thead class="bordes">
				<tr>
					<th width="70px">Cant.</th>
					<th class="textcenter" width="150px">Concepto</th>
					<th class="textcenter" width="200px">Material</th>
					<th class="textcenter" width="100px">Unidad</th>
					<th class="textcenter" width="120px">Precio Unitario.</th>
					<th class="textcenter" width="120px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos"  class="bordes">
				<tr>
					<td class="textcenter">115</td>
					<td>SUMINISTRO PISO</td>
					<td>MÁRMOL SANTO TOMAS MATE</td>
					<td class="textcenter">M2</td>
					<td class="textright">$ 550.00</td>
					<td class="textright">$ 63250.00</td>
				</tr>
				<tr>
					<td class="textcenter">115</td>
					<td>COLOCACION PISO</td>
					<td>MÁRMOL SANTO TOMAS MATE</td>
					<td class="textcenter">M2</td>
					<td class="textright">$ 220.00</td>
					<td class="textright">$ 23,500.00</td>
				</tr>
				<tr>
				<td class="textcenter">35</td>
					<td>SUMINISTRO DE MURO</td>
					<td>MÁRMOL SANTO TOMAS MATE</td>
					<td class="textcenter">M2</td>
					<td class="textright">$ 550.00</td>
					<td class="textright">$ 19,250.00</td>
				</tr>
				<tr>
				<td class="textcenter">35</td>
					<td>COLOCACION DE MURO</td>
					<td>MÁRMOL SANTO TOMAS MATE</td>
					<td class="textcenter">M2</td>
					<td class="textright">$ 220.00</td>
					<td class="textright">$ 7,700.00</td>
				</tr>
				
		
			</tbody>
			
			<tfoot id="detalle_totales">
				<tr></tr>
				<tr>
					<td colspan="5" class="textright"><span>SUBTOTAL</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="5" class="textright"><span>IVA (16%)</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="5" class="textright"><span>TOTAL</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">INCLUYE: <br>
• Los precios son en pesos mexicanos. <br>
• Colocación únicamente mano de obra. <br>
• No incluye adhesivos. <br>
• No incluye sellador ni servicio de aplicación de sellador. <br>
• No incluye andamios, tablones, etc. <br>
• No incluye entrecalles, boleos, cantos pulidos. Biseles, perforaciones, cortes 45°, etc. <br>
• Los precios son más IVA en caso de requerir Factura. <br>
• Los pagos con cheque fiscal, transferencia electrónica a cuenta fiscal generan cobro de IVA. <br>
• Se requiere un 70% de anticipo al confirmar el pedido y el 30% restante contra estimaciones semanales.<br>
• La presente cotización tiene una vigencia de 15 días a partir de su emisión. <br>
<b>Mármol, cantera y granito por ser de origen natural aceptan variación tanto en color como en veta, es norma universal el uso de estuco para corregir estos defectos. Así mismo puede sufrir diferentes comportamientos a la fricción y al medio ambiente.</b>
</p>
		<h4 class="label_gracias">¡Gracias por su preferencia!</h4>
	</div>

</div>

</body>
</html>