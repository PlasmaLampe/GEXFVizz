sigma.publicPrototype.myCircularLayout = function() {
   var R = 100,
       i = 0,
       L = this.getNodesCount();

   this.iterNodes(function(n){
     n.x = Math.cos(Math.PI*(i++)/L)*R;
     n.y = Math.sin(Math.PI*(i++)/L)*R;
   });

   return this.position(0,0,1).draw();
 };