window.onload = function() {

    $("#cy").cytoscape({

        layout: {
            name: 'arbor',
            liveUpdate: true,
            maxSimulationTime: 8000,
            ungrabifyWhileSimulating: true,
            gravity: true,
            fit: true,
            stiffness: 80,
            repulsion: 10000

        },
        showOverlay: false,
        zoomEnabled: false,
        panEnabled: false,
        boxSelectionEnabled: false,

        style: cytoscape.stylesheet()

            // ALL NODE STYLES
            .selector('node')
            .css({
                'content': 'data(name)',
                'background-color': 'data(faveColor)',
                'color': 'data(faveFontColor)',
                'text-valign': 'center',
                // 'text-opacity': 0.8,
                'font-weight': 'bold',
                'font-size': 12
            })
            .selector(":active")
            .css({
                "overlay-color": "#ffffff",
                "overlay-padding": 0,
                "overlay-opacity": 0
            }),

        elements: {
            nodes: [ { data : { shape:"dot", id: "ion", faveBorderColor: "#AAAAAA", name: "Ion", faveColor: "#EEB211", faveFontColor: "#ffffff" } },
                { data : { id: "saab", name: "Saab", faveColor: "#21526a", faveFontColor: "#fff"} },
                { data : { id: "volvo", name: "Volvo", faveColor: "#21526a", faveFontColor: "#fff"} },
                { data : { id: "benz", name: "Benz", faveColor: "#21526a", faveFontColor: "#fff"} },
                { data : { id: "suzuki", name: "Suzuki", faveColor: "#21526a", faveFontColor: "#fff"} },
                { data : { id: "BMW", name: "BMW", faveColor: "#21526a", faveFontColor: "#fff"} }
            ], //end "nodes"

            edges: [
                { data : { target: "saab", source : "ion" } },
                { data : { target: "volvo", source : "ion"} },
                { data : { target: "benz", source : "ion"} },
                { data : { target: "suzuki", source : "ion" } },
                { data : { target: "BMW", source : "ion"} }
            ]//end "edges"
        },//end "elements"

        ready: function() {

            window.cy = this;
            cy.panningEnabled(false);

            // add a listener for edges are hovered
            cy.on('tap', 'node', function(event){
                handle_click_node(event);
            });
            cy.on('mousemove','edge', function(event){
                var target = event.cyTarget;
                var sourceName = target.data("source");
                var targetName = target.data("target");
                var x=event.cyPosition.x;
                var y=event.cyPosition.y;



                var menutext = "custom content";

                $("#box").qtip({
                    content: {
                        title:targetName,
                        text: menutext
                    },
                    show: {
                        delay: 0,
                        event: false,
                        ready: true,
                        effect:false

                    },
                    position: {
                        my: 'bottom center',
                        at: 'top center',

                        target: [x+3, y+3],
                        adjust: {
                            x: 7,
                            y:7

                        }

                    },
                    hide: {
                        fixed: true,
                        event: false,
                        inactive: 700

                    },


                    style: {
                        classes: 'ui-tooltip-shadow ui-tooltip-youtube',

                        tip:
                        {
                            corner: true,
                            width: 24,         // resize the caret
                            height: 24         // resize the caret
                        }

                    }
                });

                //console.log(x)
               /* $('<div id="tooltip">' + targetName + '</div>').css( {
                    position: 'absolute',
                    display: 'none',
                    top: y+15,
                    left: x+15,
                    border: '1px solid #fdd',
                    padding: '2px',
                    'background-color': '#fee',
                    opacity: 0.80
                }).appendTo("body").show("fast");

                cy.on('mouseout','edge',function(event){
                    var target = event.cyTarget;
                    $('.selector').qtip({


                    });


                });*/

            })

//$(cytoscape)


        }//end "ready"

    });//end $("#cy").cytoscape


}//end "window.onload"
