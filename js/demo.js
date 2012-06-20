var parser;

function findBaseName(url) {
	var external = url.lastIndexOf('%2F');
	var cutURL;
	if(external == -1){
		// local url
		cutURL = url.substring(url.lastIndexOf('/') + 1);
	}else{
		// extern url
		cutURL = url.substring(url.lastIndexOf('%2F') + 3);
	}
 	return cutURL;
}

/* zoom stuff */
$(function() {
  $("#zoomCC").click(function(e) {
    e.preventDefault(); 

	$("#ccBox").zoomTarget();
	
  });
});

$(function() {
  $("#zoomDC").click(function(e) {
    e.preventDefault(); 

	$("#dcBox").zoomTarget();
	
  });
});

$(function() {
  $("#zoomBC").click(function(e) {
    e.preventDefault(); 

	$("#bcBox").zoomTarget();
	
  });
});
/* ---------------------------*/

/* Source of this snippet ? */
function getQueryVariable(variable)
{
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if(pair[0] == variable){return pair[1];}
	}
	return(false);
}
/* --------------------------- */

function init() {	
	//load meta data
	
	//load graph
  var sigInst = sigma.init($('#sigma-example')[0]).drawingProperties({
    defaultLabelColor: '#fff'
  }).graphProperties({
    minNodeSize: 0.5,
    maxNodeSize: 5
  });
	
	if(getQueryVariable('url') != false){
		parser = sigInst.parseGexf("data/"+findBaseName(getQueryVariable('url')));
	}else{
		var file = "hash/"+getQueryVariable('id')+".gexf";
		alert(file);
		parser = sigInst.parseGexf(file);
	}
	
  (function(){
    var popUp;

    function attributesToString(attr) {
      return '<ul>' +
        attr.map(function(o){
          return '<li>' + o.attr + ' : ' + o.val + '</li>';
        }).join('') +
        '</ul>';
    }

    function showNodeInfo(event) {
      popUp && popUp.remove();

      var node;
      sigInst.iterNodes(function(n){
        node = n;
      },[event.content[0]]);
 
      popUp = $(
        '<div class="node-info-popup"></div>'
      ).append(
        attributesToString( node['attr']['attributes'] )
      ).attr(
        'id',
        'node-info'+sigInst.getID()
      ).css({
        'display': 'inline-block',
        'border-radius': 3,
        'padding': 5,
        'background': '#fff',
        'color': '#000',
        'box-shadow': '0 0 4px #666',
        'position': 'absolute',
        'left': node.displayX,
        'top': node.displayY+15
      });

      $('ul',popUp).css('margin','0 0 0 20px');

      $('#sigma-example').append(popUp);
    }

    function hideNodeInfo(event) {
      popUp && popUp.remove();
      popUp = false;
    }

    sigInst.bind('overnodes',showNodeInfo).bind('outnodes',hideNodeInfo).draw();
  })();

	// hide nodes which should not show up at this time
	sigma.publicPrototype.HideWrongTimeNodes = function(value) {
		
		// update slider
		var tempcurrentDay = slider.getValue();
		slider.setValue(tempcurrentDay + value);
		currentDay = slider.getValue();
		
		// hide nodes
		L = this.getNodesCount();
		
		this.iterNodes(function(n){
		
		var localstartDate 	= n['attr']['startDate']; 
		var localendDate 	= n['attr']['endDate']; 
		
		// how many days ?
		var msecs = Date.parse(mindate);
		var msecs2 = Date.parse(maxdate);
		var diff = msecs2 - msecs;
		var alldays = (((diff / 1000) / 60) / 60) / 24;
		
		// calc diff time
		var relLocalMin = ((((Date.parse(localstartDate) - Date.parse(mindate)) / 1000) / 60) / 60) / 24;
		var relLocalMax = ((((Date.parse(maxdate) - Date.parse(localendDate)) / 1000) / 60) / 60) / 24;
			
		// find hidden nodes
		if(currentDay <= (alldays - relLocalMax) && currentDay >= relLocalMin){
			n.hidden = 0;
		}else{
			n.hidden = 1;
		}
		});
		return this.position(0,0,1).draw();
	};

	// bind the methods to buttons
	var diffdays = (maxdateInt - mindateInt)/1000/60/60/24; // difference of days

	if(diffdays > 365){
		// the graph contains probably years
		document.getElementById('PlayAnimation').addEventListener('click',function(){
			currentDay = slider.getValue();
			setInterval(function(){sigInst.HideWrongTimeNodes(+1)},300);
		},true);
		document.getElementById('Day-').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(-356);
		},true);
		document.getElementById('Day+').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(+356);
		},true);
	}else{
		// the graph contains probably days
		document.getElementById('PlayAnimation').addEventListener('click',function(){
			currentDay = slider.getValue();
			setInterval(function(){sigInst.HideWrongTimeNodes(+1)},500);
		},true);
		document.getElementById('Day-').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(-1);
		},true);
		document.getElementById('Day+').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(+1);
		},true);
	}
}

// play the animation
function playAnimation(){
	currentDay = slider.getValue();
	setInterval(function(){sigInst.HideWrongTimeNodes(+1)},1000);
}

if (document.addEventListener) {
  document.addEventListener('DOMContentLoaded', init, false);
} else {
  window.onload = init;
}