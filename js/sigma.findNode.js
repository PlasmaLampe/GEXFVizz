sigma.publicPrototype.findNode = function findNode(obj){
	var input = obj.value;
	
	var greyColor = '#666';
	var red = '#FF0000';
	// init colors
	this.iterNodes(function(n){
		if(n.color != greyColor && n.color != red)
			n.attr['true_color_find'] = n.color; // store real color
  	});

	this.iterNodes(function(n){
		if(n.label.toLowerCase().indexOf(input.toLowerCase()) != -1){
			// this node's label has a substring equal to the input
			if(input != ""){ // we have to search something
				n.color = red;
			}else{ // just clean the colors
				n.color = n.attr['true_color_find'];
			}
		}else{
			// this node has to vanish 				
			n.color = greyColor;
		}
  	});

  return this.position(0,0,1).draw();
}