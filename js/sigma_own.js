function sliderHandler(pos, slider) {
	var difference = currentDay - pos;
	sigInstGlobal.setHideWrongTimeNodes(pos);
}

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

/* 
	This function recovers the parameter from the query
	source: 
	http://www.zrinity.com/developers/code_samples/code.cfm?CodeID=59&JavaScript=Get_Query_String_variables_in_JavaScript
*/
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

function attributesToString(attr) {
  return '<ul>' +
    attr.map(function(o){
      return '<li>' + o.attr + ' : ' + o.val + '</li>';
    }).join('') +
    '</ul>';
}

function labelToPopupString(n) {
  return '<ul>' + '<li>' + n.label + '</li>' + '</ul>';
}


function attributesToSmallString(attr) {
  return attr.map(function(o){
      return o.attr + ':' + o.val;
    }).join('#');
}

function getWeightInYears(attr, from, to){
	return attr.map(function(o){
		var targetString = "weight#"+from+"#"+to;
		if(o.attr == targetString){
			return o.val;
		}else{
			return "";
		}
    }).join('');
}

function init() {		
	//load graph
  var sigInst = sigma.init($('#sigma-example')[0]).drawingProperties({
    defaultLabelColor: '#fff',
	defaultLabelSize: 12,
	defaultLabelBGColor: '#fff',
	defaultLabelHoverColor: '#000'
  }).graphProperties({
    minNodeSize: 0.5,
    maxNodeSize: 5
  });

	sigInstGlobal = sigInst; // store instance of Sigma.js
	var popUpLabels = {};
	
	if(getQueryVariable('url') != false){
		parser = sigInst.parseGexf("data/"+findBaseName(getQueryVariable('url')));
	}else{
		var file = "hash/"+getQueryVariable('id')+".gexf";
		parser = sigInst.parseGexf(file);
	}
	
	// init buttons
	updateButtonLabel("Day+",+1);
	updateButtonLabel("Day-",-1);
	
	sigInst.myRandomLayout();
	sigInst.HideWrongTimeNodes(-1);

	// bind the methods to buttons
	document.getElementById('randomlayout').addEventListener('click',function(){
		sigInst.myRandomLayout();
	},true);	
	document.getElementById('circlayout').addEventListener('click',function(){
		sigInst.myCircularLayout();
	},true);
	document.getElementById('frlayout').addEventListener('click',function(){
		sigInst.myFRLayout(100,sigInst._core);
	},true);
	
	function updateButtonLabel(id,newvalue){
		if(slider.getValue() == 0 && newvalue == -1){
			document.getElementById(id).value="N/A";
		}else if(slider.getValue() == (maxdate-mindate) && newvalue == +1){
			document.getElementById(id).value="N/A";
		}else{
			var newcalcDate = parseInt(slider.getValue()) + parseInt(mindate) + parseInt(newvalue);
			var finalvalue = "show "+newcalcDate;
			document.getElementById(id).value=finalvalue;
		}	
	}
	
	document.getElementById('highlightConnected').addEventListener('click',function(){
		if(document.getElementById('highlightConnected').checked){
			var greyColor = '#666';
			  sigInst.bind('overnodes',function(event){
			    var nodes = event.content;
				
			    var neighbors = {};
			    sigInst.iterEdges(function(e){
			      if(nodes.indexOf(e.source)<0 && nodes.indexOf(e.target)<0){
			        if(!e.attr['grey']){
			          e.attr['true_color'] = e.color;
			          e.color = greyColor;
			          e.attr['grey'] = 1;
			        }
			      }else{
			        e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
			        e.attr['grey'] = 0;

			        neighbors[e.source] = 1;
			        neighbors[e.target] = 1;
			      }
			    }).iterNodes(function(n){
			      if(!neighbors[n.id]){
			        if(!n.attr['grey']){
			          n.attr['true_color'] = n.color;
			          n.color = greyColor;
			          n.attr['grey'] = 1;
			        }
			      }else{
			        n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
			        n.attr['grey'] = 0;

					// show labels if node is not hidden
					if(n.hidden != 1 && n.displayX > 0 && n.displayY > 0 && n.displayX < 750 && n.displayY < 450){
						popUpLabels["_"+n.id] = $(
				        '<div class="node-info-popup"></div>'
				      	).append(
				        //attributesToString( n['attr']['attributes'] )
							labelToPopupString(n)
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
				        'left': n.displayX,
				        'top': n.displayY+7
				      });

				      $('ul',popUpLabels["_"+n.id]).css('margin','0 0 0 20px');

				      $('#sigma-example').append(popUpLabels["_"+n.id]);
					}
			      }
			    }).draw(2,2,2);
			  }).bind('outnodes',function(){
			    sigInst.iterEdges(function(e){
			      e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
			      e.attr['grey'] = 0;
			    }).iterNodes(function(n){
			      n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
			      n.attr['grey'] = 0;

			      //popUp && popUp.remove();
				  popUpLabels["_"+n.id] && popUpLabels["_"+n.id].remove();
			      popUpLabels["_"+n.id] = false;
			    }).draw(2,2,2);
			  });
		}else{
			sigInst.unbind('overnodes');
		}
	},true);
	document.getElementById('find').addEventListener('keyup',function(){
		sigInst.findNode(this);
	},true);
	document.getElementById('PlayAnimation').addEventListener('click',function(){
		if(runningAnimation == false){
			// start the animation
			currentDay = slider.getValue();
			animationID = setInterval(function(){playAnimation(sigInst)},500);
			runningAnimation = true;
			document.getElementById('PlayAnimation').value="Stop animation";
		}else{
			// stop the animation
			clearInterval(animationID);
			runningAnimation = false;
			document.getElementById('PlayAnimation').value="Play animation";
		}
	},true);
	document.getElementById('Day-').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(-1);
		updateButtonLabel("Day+",+1);
		updateButtonLabel("Day-",-1);
	},true);
	document.getElementById('Day+').addEventListener('click',function(){
		sigInst.HideWrongTimeNodes(+1);
		updateButtonLabel("Day+",1);
		updateButtonLabel("Day-",-1);
	},true);	
}

// play the animation
function playAnimation(sigInst){
	currentDay = slider.getValue();
	var max = maxdate - mindate;

	if(currentDay < max){
		sigInst.HideWrongTimeNodes(+1);
	}else{
		slider.setValue(0);
	}
}

if (document.addEventListener) {
  document.addEventListener('DOMContentLoaded', init, false);
} else {
  window.onload = init;
}