
// /*=============================================
// CAPTURANDO ID DE LA DIVISA DESDE
// =============================================*/
// $(".seleccionarToDivisa").change(function(){

// 	$(".idtransacc").val($(this).val().split(","));

// 	var idtransacc = $(this).val();
// 	// console.log("IdTransacc", idtransacc);

// 	var datos = new FormData();
// 	datos.append("IdTransacc", idtransacc);

// 	$.ajax({

// 		url: "ajax/proddivisas.ajax.php",
// 		method: "POST",
// 		data: datos,
// 		cache: false,
// 		contentType: false,
// 		processData: false,
// 		dataType: "json",
// 		success:function(respuesta){

// 			console.log("respuesta", respuesta);
// 			// $("#transaccion").val(respuesta["id"]);
// 			$("#titulo").val(respuesta["descripcion"]);
// 			$("#cargos").val(respuesta["cargos"]);
			

// 		}

// 	});

// })

// /*=============================================
// CAPTURANDO ID DE LA DIVISA REICIBE
// =============================================*/

// var idProducto = Number($(".idtransacc").val(""));
// var solicitado = Number($(".montoenvia").val("0"));
// var enviar = Number($(".montorecibe").val("0"));

// $(".seleccionarFromDivisa").change(function(){

// var solicitado = Number($(".montoenvia").val());
// var envia = Number($(this).val().split(",") * Number(solicitado));

// console.log("idProducto", idProducto);

// // $(this).val().split(",");
// // console.log(descripcion);	
// // console.log($(this).val().split(","));
	
// $(".TasaCambio span").html($(this).val().split(","));
// $(".montorecibe").val(envia);

	
// 	var divisa = $(this).val();

// 	$(".seleccionarSubCategoria").html("");

// 	var datos = new FormData();
// 	datos.append("idDivisa", divisa);

// 	//  $.ajax({
// 	//     url:"ajax/divisas.ajax.php",
// 	//     method:"POST",
// 	//     data: datos,
// 	//     cache: false,
// 	//     contentType: false,
// 	//     processData: false,
// 	//     dataType: "json",
// 	//     success:function(respuesta){
	    	
// 	//     	console.log("respuesta", respuesta);

// 	//     	$(".entradaSubcategoria").show();

// 	//     	respuesta.forEach(funcionForEach);

// 	//         function funcionForEach(item, index){
// 	// 			console.log("item", item.id);

// 	//         	$(".seleccionarSubCategoria").append(

//     // 				'<option value="'+item["id"]+'">'+item["subcategoria"]+'</option>'

//     // 			)

// 	//         }

// 	//     }

// 	// })

// })



// /*=============================================
// /*=============================================
// /*=============================================
// /*=============================================
// /*=============================================
// AGREGAR	TRANSACCION
// =============================================*/

// $(".agregarTransac").click(function(){

// 	var idProducto = Number($(".idtransacc").val());
// 	var montoenvia = Number($(".montoenvia").val());
// 	var monedaenvia = $(".monedaenvia").val();
// 	var titulo = $(".titulo").val();
// 	var montorecibe = $(".montorecibe").val();
// 	var cargos = $(".cargos").val();

// 	// console.log(idProducto);
// 	console.log(monedaenvia);

// 	var agregarAlCarrito = false;

// 	/*=============================================
// 	CAPTURAR DETALLES
// 	// =============================================*/

// 	// if(tipo == "virtual"){

// 		agregarAlCarrito = true;

// 	// }else{

// 	// 	var seleccionarDetalle = $(".seleccionarDetalle");

// 	// 	for(var i = 0; i < seleccionarDetalle.length; i++){

// 	// 		if($(seleccionarDetalle[i]).val() == ""){

// 	// 			swal({
// 	// 				  title: "Debe seleccionar Talla y Color",
// 	// 				  text: "",
// 	// 				  type: "warning",
// 	// 				  showCancelButton: false,
// 	// 				  confirmButtonColor: "#DD6B55",
// 	// 				  confirmButtonText: "¡Seleccionar!",
// 	// 				  closeOnConfirm: false
// 	// 				})

// 	// 		}else{

// 	// 			titulo = titulo + "-" + $(seleccionarDetalle[i]).val();

// 	// 			agregarAlCarrito = true;

// 	// 		}

// 	// 	}		

// 	// }

// 	/*=============================================
// 	ALMACENAR EN EL LOCALSTARGE LOS PRODUCTOS AGREGADOS AL CARRITO
// 	=============================================*/

// 	if(agregarAlCarrito){

// 		/*=============================================
// 		RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE
// 		=============================================*/

// 		if(localStorage.getItem("listaProductos") == null){

// 			listaCarrito = [];

// 		}else{

// 			var listaProductos = JSON.parse(localStorage.getItem("listaProductos"));

// 			for(var i = 0; i < listaProductos.length; i++){

// 				if(listaProductos[i]["idProducto"] == idProducto){

// 					swal({
// 					  title: "El producto ya está agregado al carrito de compras",
// 					  text: "",
// 					  type: "warning",
// 					  showCancelButton: false,
// 					  confirmButtonColor: "#DD6B55",
// 					  confirmButtonText: "¡Volver!",
// 					  closeOnConfirm: false
// 					})

// 					return;

// 				}

// 			}

// 			listaCarrito.concat(localStorage.getItem("listaProductos"));

// 		}

// 		listaCarrito.push({"idProducto":idProducto,
// 						   "titulo":titulo,
// 						   "precio":montorecibe,
// 					       "tipo":montoenvia,
// 				           "cantidad":cargos});
		
// 		console.log("listaCarrito", listaCarrito);

// 		localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

// 		/*=============================================
// 		ACTUALIZAR LA CESTA
// 		=============================================*/

// 		var cantidadCesta = Number($(".cantidadCesta").html()) + 1;
// 		var sumaCesta = Number($(".sumaCesta").html()) + Number(precio);

// 		$(".cantidadCesta").html(cantidadCesta);
// 		$(".sumaCesta").html(sumaCesta);

// 		localStorage.setItem("cantidadCesta", cantidadCesta);
// 		localStorage.setItem("sumaCesta", sumaCesta);
		
// 		/*=============================================
// 		MOSTRAR ALERTA DE QUE EL PRODUCTO YA FUE AGREGADO
// 		=============================================*/

// 		swal({
// 			  title: "",
// 			  text: "¡Se ha agregado un nuevo producto al carrito de compras!",
// 			  type: "success",
// 			  showCancelButton: true,
// 			  confirmButtonColor: "#DD6B55",
// 			  cancelButtonText: "¡Continuar comprando!",
// 			  confirmButtonText: "¡Ir a mi carrito de compras!",
// 			  closeOnConfirm: false
// 			},
// 			function(isConfirm){
// 				if (isConfirm) {	   
// 					 window.location = rutaOculta+"carrito-de-compras";
// 				} 
// 		});

// 	}

// })
