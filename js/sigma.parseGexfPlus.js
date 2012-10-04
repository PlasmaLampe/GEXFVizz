// Mathieu Jacomy @ Sciences Po Médialab & WebAtlas
// (requires sigma.js to be loaded)
var typeOfGraph="";
	
sigma.publicPrototype.parseGexf = function(gexfPath) {	
  // Load XML file:
  var gexfhttp, gexf;
  var sigmaInstance = this;
  gexfhttp = window.XMLHttpRequest ?
    new XMLHttpRequest() :
    new ActiveXObject('Microsoft.XMLHTTP');

  gexfhttp.overrideMimeType('text/xml');
  gexfhttp.open('GET', gexfPath, false);
  gexfhttp.send();
  gexf = gexfhttp.responseXML;

  var viz='http://www.gexf.net/1.2draft/viz'; // Vis namespace
  var i, j, k;
	
	// HACK #0
	var graphInitStuff = gexf.getElementsByTagName('graph');
	typeOfGraph = graphInitStuff[0].getAttribute('timeformat');
	//
	
  // Parse Attributes
  // This is confusing, so I'll comment heavily
  var nodesAttributes = [];   // The list of attributes of the nodes of the graph that we build in json
  var edgesAttributes = [];   // The list of attributes of the edges of the graph that we build in json
  var attributesNodes = gexf.getElementsByTagName('attributes');  // In the gexf (that is an xml), the list of xml nodes 'attributes' (note the plural 's')
  
  for(i = 0; i<attributesNodes.length; i++){
    var attributesNode = attributesNodes[i];  // attributesNode is each xml node 'attributes' (plural)
    if(attributesNode.getAttribute('class') == 'node'){
      var attributeNodes = attributesNode.getElementsByTagName('attribute');  // The list of xml nodes 'attribute' (no 's')
      for(j = 0; j<attributeNodes.length; j++){
        var attributeNode = attributeNodes[j];  // Each xml node 'attribute'
        
        var id = attributeNode.getAttribute('id'),
          title = attributeNode.getAttribute('title'),
          type = attributeNode.getAttribute('type');
        
        var attribute = {id:id, title:title, type:type};
        nodesAttributes.push(attribute);
        
      }
    } else if(attributesNode.getAttribute('class') == 'edge'){
      var attributeNodes = attributesNode.getElementsByTagName('attribute');  // The list of xml nodes 'attribute' (no 's')
      for(j = 0; j<attributeNodes.length; j++){
        var attributeNode = attributeNodes[j];  // Each xml node 'attribute'
        
        var id = attributeNode.getAttribute('id'),
          title = attributeNode.getAttribute('title'),
          type = attributeNode.getAttribute('type');
          
        var attribute = {id:id, title:title, type:type};
        edgesAttributes.push(attribute);
        
      }
    }
  }
  
  var nodes = []; // The nodes of the graph
  var nodesNodes = gexf.getElementsByTagName('nodes') // The list of xml nodes 'nodes' (plural)
  
  for(i=0; i<nodesNodes.length; i++){
    var nodesNode = nodesNodes[i];  // Each xml node 'nodes' (plural)
    var nodeNodes = nodesNode.getElementsByTagName('node'); // The list of xml nodes 'node' (no 's')

    for(j=0; j<nodeNodes.length; j++){
      var nodeNode = nodeNodes[j];  // Each xml node 'node' (no 's')
      
      window.NODE = nodeNode;

      var id = nodeNode.getAttribute('id');
      var label = nodeNode.getAttribute('label') || id;
      var start = nodeNode.getAttribute('start');
      var end = nodeNode.getAttribute('end');
      
      //viz
      var size = 1;
      var x = 100 - 200*Math.random();
      var y = 100 - 200*Math.random();
      var color;
      
      var sizeNodes = nodeNode.getElementsByTagName('size');
      sizeNodes = sizeNodes.length ? 
                  sizeNodes : 
                  nodeNode.getElementsByTagNameNS('*','size');
      if(sizeNodes.length>0){
        sizeNode = sizeNodes[0];
        size = parseFloat(sizeNode.getAttribute('value'));
      }

      var positionNodes = nodeNode.getElementsByTagName('position');
      positionNodes = positionNodes.length ? 
                      positionNodes : 
                      nodeNode.getElementsByTagNameNS('*','position');
      if(positionNodes.length>0){
        var positionNode = positionNodes[0];
        x = parseFloat(positionNode.getAttribute('x'));
        y = parseFloat(positionNode.getAttribute('y'));
      }

      var colorNodes = nodeNode.getElementsByTagName('color');
      colorNodes = colorNodes.length ? 
                   colorNodes : 
                   nodeNode.getElementsByTagNameNS('*','color');
      if(colorNodes.length>0){
        colorNode = colorNodes[0];
        color = '#'+sigma.tools.rgbToHex(parseFloat(colorNode.getAttribute('r')),
                                         parseFloat(colorNode.getAttribute('g')),
                                         parseFloat(colorNode.getAttribute('b')));
      }

	// Create Node
		var node;
      if(color !== 'undefined')
		node = {label:label, size:size, x:x, y:y, attributes:[], color:"rgb(100,150,100)", startDate:start, endDate:end};  // The graph node
	  else
        node = {label:label, size:size, x:x, y:y, attributes:[], color:color, startDate:start, endDate:end};  // The graph node
      

      // *** *** ***
	  // !! HACK
		if(mindate == -1){ // first date, set it
			mindate = start;
			maxdate = end;
			if(typeof(maxdate) !== 'undefined' && maxdate != null){
				// fine ...
			}else{
				maxdate = start;
			}
		} // now, check
		
		if(mindate > start && start != null){
			mindate = start;
		}
		if(maxdate < end){
			maxdate = end;
		}
		if(maxdate < start){
			maxdate = start;
		}
		
		node.attributes.push({attr:'start', val:start});
		if(end != null){
			node.attributes.push({attr:'end', val:end});
		}else{
			node.attributes.push({attr:'end', val:"max"});
		}
	  // 
      // *** *** ***


      // Attribute values
      var attvalueNodes = nodeNode.getElementsByTagName('attvalue');
      for(k=0; k<attvalueNodes.length; k++){
        var attvalueNode = attvalueNodes[k];
        var attr = attvalueNode.getAttribute('for');
        var val = attvalueNode.getAttribute('value');
        node.attributes.push({attr:attr, val:val});
      }

      sigmaInstance.addNode(id,node);
    }
  }
	// *** *** ***
	// HACK 2
	var year = maxdate - mindate;
	
	if(typeof(mindate) !== 'undefined' && mindate != null){
		$('div.out').html("<h3>This graph contains " + year + " time units</h3><br>");
		
		window.dhx_globalImgPath = "slider_codebase/imgs/";
		slider = new dhtmlxSlider("sliderBox", 700);
		slider.setImagePath("slider_codebase/imgs/");
		slider.setSkin('dhx_skyblue');	
		slider.setMax(year);
		slider.attachEvent("onChange", sliderHandler);
		slider.init();
		$('div.from').html("view starts at " + mindate);
		$('div.to').html("and finishes at " + maxdate);
	}else{
		$('div.out').html("<h3>This is a static graph</h3><br>");
		
		$('div.from').hide();
		$('div.to').hide();
		$('div.buttons-container').hide();
	}
	// *** *** ***
			
  var edges = [];
  var edgeId = 0;
  var edgesNodes = gexf.getElementsByTagName('edges');
  for(i=0; i<edgesNodes.length; i++){
    var edgesNode = edgesNodes[i];
    var edgeNodes = edgesNode.getElementsByTagName('edge');
    for(j=0; j<edgeNodes.length; j++){
      var edgeNode = edgeNodes[j];
      var source = edgeNode.getAttribute('source');
      var target = edgeNode.getAttribute('target');
      var label = edgeNode.getAttribute('label');
      var estart = edgeNode.getAttribute('start');
      var eend = edgeNode.getAttribute('end');

      var edge = {
        id:         j,
        sourceID:   source,
        targetID:   target,
        label:      label,
        attributes: []
      };

      // *** *** ***
	  // !! HACK
		if(mindate == -1){ // first date
			mindate = estart;
			maxdate = eend;
		} // now, check
		
		if(mindate > estart && estart != null){
			mindate = estart;
		}
		if(maxdate < eend || maxdate == null){
			maxdate = eend;
		}
		if(maxdate < estart){
			maxdate = estart;
		}
		
		edge.attributes.push({attr:'start', val:estart});
		edge.attributes.push({attr:'end', val:eend});
	  // 
      // *** *** ***

      var weight = edgeNode.getAttribute('weight');
      if(weight!=undefined){
        edge['weight'] = weight;
      }

      var attvalueNodes = edgeNode.getElementsByTagName('attvalue');

      for(k=0; k<attvalueNodes.length; k++){
        var attvalueNode = attvalueNodes[k];
        var attr = attvalueNode.getAttribute('for');
        var val = attvalueNode.getAttribute('value');

       	var edgeStart;
		var edgeEnd;

		if(attvalueNode.getAttribute('start') != null){
			edgeStart = attvalueNode.getAttribute('start');
		}else{
			edgeStart = 0;
		} 
		
		if(attvalueNode.getAttribute('end') != null){
			edgeEnd = attvalueNode.getAttribute('end');
		}else{
			edgeEnd = 0;
		}
		
		var attrWithStartAndEnd = attr + "#" + edgeStart + "#" + edgeEnd;
		
		/* mini hack to save the weight out of attvalues*/
		if(attr=='weight'){
			edge['weight'] = val;
		}
		/* -----------*/
		
		if(edgeStart == 0 && edgeEnd == 0){
			edge.attributes.push({attr:attr, val:val});
		}else{
			edge.attributes.push({attr:attrWithStartAndEnd, val:val});
		}
        
      }

      sigmaInstance.addEdge(edgeId++,source,target,edge);
    }
  }
};


 

