$(function ()  
{ $("#ccHover").popover({title: 'Closeness Centrality', content: "The distance of two nodes is the number of ’steps’ you need to go to get from one node to the other one. Therefore, to get a score for 'closeness', we take the needed distances and add them up. Because we want to get a small value for the metric whenever the distances are high, we use the reciprocal of the summed distances and standardize it by multiplying it with n-1 (n = the number of nodes in this graph)."});  
});

$(function ()  
{ $("#dcHover").popover({title: 'Degree Centrality', 
	content: "The degree centrality of a node illustrates the number of edges which are attached to the node. In order to know the standardized score, we need to divide this value by n-1 (n = the number of nodes in this graph).  "});  
});

$(function ()  
{ $("#bcHover").popover({title: 'Betweenness Centrality', content: "To calculate betweenness centrality, we take every pair of nodes within the network and count how many times a node is placed on the shortest paths between this pair of nodes. After that, we need to divide this value by (n-1)(n-2)/2 (n = the number of nodes in this graph) for standardization."});  
});