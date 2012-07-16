sigma.publicPrototype.myFRLayout = function(iterations,sig) {
	// FR variables
	var HEIGHT = 100;
	var WIDTH = 100;
	
	var area = 100 * 100;
	var temperature = 80;
	var cooldown = temperature/iterations;
	var k = Math.sqrt(area / this.getNodesCount());
	
	// start with random positions
	  var W = 100,
      H = 100;

	this.iterNodes(function(n){
    	n.x = W*Math.random();
    	n.y = H*Math.random();
  	});
	
	// now, calculate FR-algorithm
	function attractiveForce(x){
		return (x * x) / k;
	}
	
	function repulsiveForce(x){
		return (k * k) / x;
	}
	
	function calculateRepulsiveForces(){
		var vDelta = new Vector2(0,0);
		
			sig.graph.nodes.forEach(function(n){
			var vDisplacement = new Vector2(0,0);
			n['attr']['displacementX'] = 0;
			n['attr']['displacementY'] = 0;
			
				sig.graph.nodes.forEach(function(u){
					if(n.x != u.x && n.y != u.y){
						var posN = new Vector2(n.x,n.y);
						var posU = new Vector2(u.x,u.y);
					
						vDelta = posN.sub(posU);
						vDisplacement = vDelta.norm(null).mul(repulsiveForce(vDelta.mag()));
						
						n['attr']['displacementX'] += vDisplacement.x;
						n['attr']['displacementY'] += vDisplacement.y;
					}
				});
	  		});
	}
	
	function calculateAttractiveForces(){	
		sig.graph.edges.forEach(function(e){
			var sourceIndex = e.source;
			var targetIndex = e.target;
			
			var snode = e.source;
			var enode = e.target;
			
			vDelta = new Vector2(snode.x - enode.x, snode.y - enode.y);
			
			var sDis = vDelta.norm(null).mul(attractiveForce(vDelta.mag()));
			
			sig.graph.nodesIndex[snode.id].attr.displacementX -= sDis.x;
			sig.graph.nodesIndex[snode.id].attr.displacementY -= sDis.y;
			sig.graph.nodesIndex[enode.id].attr.displacementX += sDis.x;
			sig.graph.nodesIndex[enode.id].attr.displacementY += sDis.y;
			
		});
	}
	
	function performDisplacement(){
		sig.graph.nodes.forEach(function(n){
			var posVector = new Vector2(n.x,n.y);
			var disVector = new Vector2(n['attr']['displacementX'],n['attr']['displacementY']);
			var min = Math.min(disVector.mag(),temperature);
			
			var newPosition = disVector.mul(min);
			n.x = newPosition.x;
			n.y = newPosition.y;
		});
	}
	
	function coolDown(){
		temperature = temperature - cooldown;

	    if (temperature < cooldown)
	    	temperature = 0;
	}
	
	// main calculation is done here:
	for(var i=0;i<iterations;i++){
   		calculateRepulsiveForces();
   		calculateAttractiveForces();
   		performDisplacement();
   		coolDown();
   }

   return this.position(0,0,1).draw();
 };