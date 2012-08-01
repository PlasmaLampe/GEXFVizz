sigma.publicPrototype.findNode = function findNode(obj){
	var input = obj.value;
	
	var greyColor = '#666';

	// init colors
	this.iterNodes(function(n){
		if(n.color != greyColor)
			n.attr['true_color_find'] = n.color;
  	});

	this.iterNodes(function(n){
		if(n.label.indexOf(input) != -1){
			// this node's label has a substring equal to the input
			n.color = n.attr['true_color_find'];
		}else{
			// this node has to vanish 				
			n.color = greyColor;
		}
  	});

  return this.position(0,0,1).draw();
}