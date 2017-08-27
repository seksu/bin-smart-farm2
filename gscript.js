
nv.addGraph(function() {
	

  var chart = nv.models.lineChart()
                .margin({left: 100})  //Adjust chart margins to give the x-axis some breathing room.
               	.useInteractiveGuideline(false)  //We want nice looking tooltips and a guideline!
              
                .showLegend(true)       //Show the legend, allowing users to turn on/off line series.
                .showYAxis(true)        //Show the y-axis
                .showXAxis(true)        //Show the x-axis
                //.width(width)
                //.height(height)
               	.useVoronoi(false)
              	.isArea(false)

  ;
  chart.interactiveLayer.tooltip.fixedTop(100);
  chart.clipEdge(false);
  // chart.xAxis     //Chart x-axis settings
  //     .axisLabel('Time (ms)')
  //     .tickFormat(d3.format(',r'));

  chart.yAxis     //Chart y-axis settings
      .axisLabel('Percent')
      .tickFormat(d3.format('.02f'));

  /* Done setting the chart up? Time to render it!*/
  var myData = sinAndCos();   //You need data...

  d3.select('#nodeChart svg')    //Select the <svg> element you want to render the chart in.   
      .datum(myData)         //Populate the <svg> element with chart data...
      //.style({ 'width': width, 'height': height })
      .call(chart);          //Finally, render the chart!

  //Update the chart when window resizes.
  nv.utils.windowResize(function() { chart.update() });
  return chart;
});

/**************************************
 * Simple test data generator
 */
  