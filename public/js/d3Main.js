var margin = {top: 10, right: 10, bottom: 10, left: 10},
    width = 8000 - margin.right - margin.left,
    height = 10500 - margin.top - margin.bottom;

var i = 0,
    duration = 1,
    root;

var tree = d3.layout.tree()
    .size([width, height]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.x, d.y]; });

var svg = d3.select(".page").append("svg")
    .attr("width", width + margin.right + margin.left)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json(fileName, function(error, flare) {

    if (error) throw error;

    root = flare;
    root.x0 = height / 2;
    root.y0 = 0;

    function collapse(d) {

        if (d.children) {

            d._children = d.children;
            d._children.forEach(collapse);
            d.children = null;
        }
    }

    // root.children.forEach(collapse);
    update(root);
});

d3.select(self.frameElement).style("height", "200px");

function update(source) {

  // Compute the new tree layout.
  var nodes = tree.nodes(root).reverse(),
      links = tree.links(nodes);

  // Normalize for fixed-depth.
  nodes.forEach(function(d) { d.y = d.depth * 100; });

  // Update the nodes…
  var node = svg.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });

  // Enter any new nodes at the parent's previous position.
  var nodeEnter = node.enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + source.x0 + "," + source.y0 + ")"; })

  nodeEnter.append("circle")
      .attr("r", 1e-6)
      .style("fill", function(d) { return d._children ? "#FFC3C3" : "#fff"; })
      .on("click", click);

  nodeEnter.append("text")
      .attr("x", function(d) { return d.children || d._children ? 15 : 15; })
      .attr("dy", ".35em")
      .attr("text-anchor", function(d) { return d.children || d._children ? "start" : "start"; })
      .text(function(d) { return d.name; })
      .style("fill-opacity", 1)
      .on("click", openLocation);

  // Transition nodes to their new position.
  var nodeUpdate = node.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  nodeUpdate.select("circle")
      .attr("r", 7)
      .style("fill", function(d) { return d._children ? "#8B0000" : "#fff"; });

  // nodeUpdate.select("text")
  //     .style("fill-opacity", function(d) { return d.url ? "1" : "0.4"; });

  nodeUpdate.select("text")
      .style("fill", function(d) { 

        if(!d.url) return "#555555";
        return (d.url.match(/acharya/)) ? "#0091EA" : "#2E7D32"; 
      });

  // Transition exiting nodes to the parent's new position.
  var nodeExit = node.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.x + "," + source.y + ")"; })
      .remove();

  nodeExit.select("circle")
      .attr("r", 1e-6);

  nodeExit.select("text")
      .style("fill-opacity", 1);

  // Update the links…
  var link = svg.selectAll("path.link")
      .data(links, function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      });

  // Transition links to their new position.
  link.transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition exiting nodes to the parent's new position.
  link.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();

  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}

// Toggle children on click.
function openLocation(d) {
  if(d.url === undefined) return;
  window.open(BASE_URL + d.url, '_blank');
}

function click(d) {
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  update(d);
}
