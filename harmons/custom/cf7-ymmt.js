
// ymmt stuff.
jQuery(document).ready(function() {

	// when make changes....
	jQuery('#ymmt-make').change(function() {

		var newmake_val = document.getElementById('ymmt-make').value;
		
		// clear out the model DDL
		var modelDDL = document.getElementById('ymmt-model'); 
		var ddllen = modelDDL.length;
		for (i=ddllen; i > 0 ; i--) { // remove anything besides first entry.
			modelDDL.remove(i);
		}
		modelDDL.value = 0;  // set value selected back to zero;
		// clear out the year DDL 
		var yearDDL = document.getElementById('ymmt-year');
		ddllen = yearDDL.length;
		for (i=ddllen; i > 0; i--) { 
			yearDDL.remove(i);
		}
		yearDDL.value=0;
		// clear out the trim DDL
		var trimDDL = document.getElementById('ymmt-trim');
		ddllen = trimDDL.length
		for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
			trimDDL.remove(i);
		}
		trimDDL.value=0;
		// clear out tiresize DDL 
		var tiresizeDDL = document.getElementById('ymmt-tiresize');
		if (tiresizeDDL) {
			ddllen = tiresizeDDL.length
			for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
				tiresizeDDL.remove(i);
			}
			tiresizeDDL.value=0;
		} 

		if (newmake_val != 0 ) { 
/* fill model ddl from the data saved on the form  */
			var ymmtAll = document.getElementById('ymmt-all').innerHTML;
			var ymmtObj = JSON.parse(ymmtAll);
			var ymmtmodels = ""; 
			if (ymmtAll == "") {
				alert('nothing');
			} else {
				var ymmtmakes = ymmtObj.makes;
				for (i=0; i<ymmtmakes.length;i++) {
					if (newmake_val  == ymmtmakes[i].niceName) {
						ymmtmodels = ymmtmakes[i].models;
						break;
					}
				}
				if (ymmtmodels != "") {
					for (i=0; i < ymmtmodels.length; i++) {
						var option = document.createElement("option");
						option.text = ymmtmodels[i].name;
						option.value = ymmtmodels[i].niceName;
						//console.log(  "model_name(" + i + ") = " + option.text);
						modelDDL.add(option);
					}
				}
			}
		
		} else {
			console.log("make reset.");
		}

	}); /* end of #ymmt-make change function */

// what to do when the model changes.
	jQuery('#ymmt-model').change(function() {

		var newmodel = document.getElementById('ymmt-model').value; 
		var newmake_val = document.getElementById('ymmt-make').value;

		// clear out the year DDL 
		var yearDDL = document.getElementById('ymmt-year');
		ddllen = yearDDL.length;
		for (i=ddllen; i > 0; i--) { 
			yearDDL.remove(i);
		}
		yearDDL.value=0;
		// clear out the trim DDL
		var trimDDL = document.getElementById('ymmt-trim');
		ddllen = trimDDL.length
		for (i=ddllen; i > 0; i--) { 
			trimDDL.remove(i);
		}
		trimDDL.value=0;
		// clear out tiresize DDL 
		var tiresizeDDL = document.getElementById('ymmt-tiresize');
		if (tiresizeDDL) {
			ddllen = tiresizeDDL.length
			for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
				tiresizeDDL.remove(i);
			}
			tiresizeDDL.value=0;
		} 


		var ymmtAll = document.getElementById('ymmt-all').innerHTML;
		var ymmtObj = JSON.parse(ymmtAll);
		var ymmtmodels = ""; 
		if (ymmtAll == "") {
			//alert('nothing');
		} else {
			var ymmtmakes = ymmtObj.makes;
			for (i=0; i<ymmtmakes.length;i++) {
				if (newmake_val  == ymmtmakes[i].niceName) {
					ymmtmodels = ymmtmakes[i].models;
					break;
				}
			}
			var ymmtyears = "";
			if (ymmtmodels != "") { // found the make, now need to find the make
				for (i=0; i < ymmtmodels.length; i++) {
					if (newmodel == ymmtmodels[i].niceName) {
						ymmtyears = ymmtmodels[i].years;
					}
				}
			} else {
				//console.log("model change: didnt find model");
			}
			if (ymmtyears != "") {
				for (i=0; i < ymmtyears.length; i++) {
					var option = document.createElement("option");
					option.text = ymmtyears[i].year;
					//console.log(  "model_name(" + i + ") = " + option.text);
					yearDDL.add(option);
				}
			} else {
				//console.log("no years");
			}
		}
	});/* end of #ymmt-model change function */
	
	jQuery('#ymmt-year').change(function() {
		
		// clear out trim levels
		// clear out the trim DDL
		var trimDDL = document.getElementById('ymmt-trim');
		ddllen = trimDDL.length
		for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
			trimDDL.remove(i);
		}
		trimDDL.value=0;

		var tiresizeDDL = document.getElementById('ymmt-tiresize');
		if (tiresizeDDL) {
			ddllen = tiresizeDDL.length
			for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
				tiresizeDDL.remove(i);
			}
			tiresizeDDL.value=0;
		}

		 // fill the trim Select from Edmunds
		var apikey = "7rweramx4rubxsya5m5978bj";
		var baseUrl = "http://api.edmunds.com/api/vehicle/v2/";
		var newmake = document.getElementById('ymmt-make').value;
		var newmodel = document.getElementById('ymmt-model').value;  
		var newyear = document.getElementById('ymmt-year').value;
		var trimDDL = document.getElementById('ymmt-trim');

		targetURL = baseUrl +  newmake + "/" + newmodel + "/" + newyear + "?fmt=json&api_key=" + apikey;
		// send off the query
		var xmlhttp;
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else {// code for IE6, IE5
		  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
				var TrimObj = JSON.parse(response);
				var trims = TrimObj.styles;
				//console.log("year change: trims is:" + trims);
				if (trims.length > 0 ) {
					for (i=0; i < trims.length; i++) {
						var option = document.createElement("option");
						option.text = trims[i].name;
						//option.value = trims[i].id;
						option.value = trims[i].name;
						trimDDL.add(option);
					}
				} else {
					//console.log("year change: no trims");
				}

			}
		}
		xmlhttp.open("GET",targetURL,true);
		xmlhttp.send();

	}); /* end of #ymmt-year change function */
/* --------------------- */


	jQuery('#ymmt-trim').change(function() {
		var trimDDL = document.getElementById('ymmt-trim');
		var tiresizeDDL = document.getElementById('ymmt-tiresize');
		if (tiresizeDDL) {
			ddllen = tiresizeDDL.length
			for (i=ddllen; i > 0; i--) { // remove anything besides first entry.
				tiresizeDDL.remove(i);
			}
			tiresizeDDL.value=0;

	 		// fill the desc Select from Edmunds
			var apikey = "7rweramx4rubxsya5m5978bj";
			var baseUrl = "http://api.edmunds.com/api/vehicle/v2/styles/";
			targetURL = baseUrl +  trimDDL.value + "/equipment?fmt=json&equipmentType=TIRES&api_key=" + apikey;

			var xmlhttp;
			if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else {// code for IE6, IE5
			  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var response = xmlhttp.responseText;
					var TireObj = JSON.parse(response);
	console.log(response);
					var Tires = TireObj.equipment;
					if (Tires.length > 0 ) {
						 for (i=0; i < Tires.length; i++) {
						 	var tirewidth = "";
						 	var tireprofile = "";
						 	var tirediameter = "";
						 	for (j=0; j< Tires[i].attributes.length; j++) {

						 		//console.log("name is:"+ Tires[i].attributes[j].name + " with vale: "+ Tires[i].attributes[j].value);
						 		if (Tires[i].attributes[j].name == "Rear Tire Width") {
						 			tirewidth = Tires[i].attributes[j].value;
						 		}
						 		if (Tires[i].attributes[j].name == "Rear Tire Profile") {
						 			tireprofile = Tires[i].attributes[j].value;
						 		}
						 		if (Tires[i].attributes[j].name == "Rear Tire Diameter") {
						 			tirediameter= Tires[i].attributes[j].value;
						 		}
						 	}
						 	tire_desc = tirewidth + " " + tireprofile + " " + tirediameter;
						 	if (tire_desc != "" ) {
	console.log("tire desc: " + tire_desc);
						 		var option = document.createElement("option");
								option.text = tire_desc;
								option.value = Tires[i].id;
								tiresizeDDL.add(option); 
						 	}

						}
					} else {
						console.log("trim change: no tires");
					}

				}
			}
			xmlhttp.open("GET",targetURL,true);
			xmlhttp.send();
		} 
	}); /* end of #ymmt-trim change function */
});

