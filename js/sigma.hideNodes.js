// hide nodes which should not show up at this time
sigma.publicPrototype.HideWrongTimeNodes = function(value) {
	// update slider
	var tempcurrentDay = slider.getValue();
	slider.setValue(tempcurrentDay + value);
	currentDay = slider.getValue();
	
	// hide nodes
	this.iterNodes(function(n){	
	var localstartDate 	= n['attr']['startDate']; 
	var localendDate 	= n['attr']['endDate']; 

	if(localendDate == null){
		localendDate = maxdate;
	}
	
	// how many years ?
	var alldays = maxdate - mindate;

	// calc diff time
	var relLocalMin = localstartDate - mindate;
	var relLocalMax = maxdate - localendDate;

	// find hidden nodes
	if(currentDay <= (alldays - relLocalMax) && currentDay >= relLocalMin){
		n.hidden = 0;
		
	}else{
		n.hidden = 1;
	}
	});
	
	var starthere = parseInt(currentDay) + parseInt(mindate);
	var stophere = starthere + 1;
	
	// hide edges
	this.iterEdges(function(e){
		var curWeight = getWeightInYears(e['attr']['attributes'],starthere, stophere);
		
		if(curWeight == ""){
			//e.hidden = 1;
			e.weight = 1; // set weight to 1 as default
		}else{
			//alert(curWeight);
			e.weight = (curWeight * 2)-1; // this formula should highlight high weight values 
			//e.hidden = 0;
		}
  	});
	return this.position(0,0,1).draw();
};