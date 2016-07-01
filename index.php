<!DOCTYPE HTML>
<title>Trabalho DB</title>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" type="text/javascript" src="arbor.js"></script>
    <script type="text/javascript" type="text/javascript" src="arbor-tween.js"></script>
    <script type="text/javascript" type="text/javascript" src="renderer.js"></script>
    <script type="text/javascript" type="text/javascript" src="graphics.js"></script>

    <script type="text/javascript" type="text/javascript" src="cytoscape.js"></script>
    <script type="text/javascript" type="text/javascript" src="cytoscape.min.js"></script>

    <script type="text/javascript" type="text/javascript" src="jquery.qtip.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery.qtip.css">

</head>
    <body>
        <?php
            /**
             * Created by PhpStorm.
             * User: Rahul, Bruno Asato
             * Date: 5/1/14
             * Time: 12:16 PM
             * Update: 30/06/2016
             * Time: 23:00 PM
             */
            $host = "localhost";
            $user = "root";
            $pass = "";
            $connect=mysql_connect($host,$user,$pass) or die("Error connecting!! Check connection parameters");
            $sql_column_table = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'ejem'";
            $sql_fk_table = "SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'ejem' AND REFERENCED_TABLE_NAME IS NOT NULL";
            $column_table = mysql_query($sql_column_table) or die(mysql_error());
            $fk_table = mysql_query($sql_fk_table) or die(mysql_error());
            $a=array();
            $b=array();
            $flag = '';
            $string = '';
            while($row=mysql_fetch_array($fk_table)){
                extract($row);
                    $string .= "\n " . $REFERENCED_TABLE_NAME . ":{";
                $string .= "\n \t" . $TABLE_NAME . ":{},";
                    $string .= "\n },";
                $flag = $REFERENCED_TABLE_NAME;
            }
            $flag = '';
            $colunas = '';
            while($dados = mysql_fetch_array($column_table)) {
                //echo "<pre>";
                //die(print_r($dados));
                extract($dados);
                if($flag != $TABLE_NAME) {
                    $colunas .= "<br /><br />"; 
                    $colunas .= "<br /><h3>" . strtoupper($TABLE_NAME) . "</h3>";
                }                
                $colunas .= "<br /> " . $COLUMN_NAME;
                if(isset($COLUMN_KEY) && $COLUMN_KEY != '') {
                    $colunas .= " [" . $COLUMN_KEY . "]";    
                }
                if(isset($EXTRA) && $EXTRA != '') {
                    $colunas .= " [" . $EXTRA . "]";    
                }                
                
                $flag = $TABLE_NAME;

                //echo "<pre>";
                //die(print_r($dados));
            }
            
        ?>

        ---------------------------------------------------------------------------------------
        <div>
            <canvas id="docs" width="800" height="800"></canvas>
        </div>  
        <?php echo $colunas;?>

        <script type="text/javascript">
        //
        //  main.js
        //
        //  A project template for using arbor.js
        //

        (function($){
            var Renderer = function(canvas){
            var canvas = $(canvas).get(0)
            var ctx = canvas.getContext("2d");
            var particleSystem

            var that = {
              init:function(system){
                //
                // the particle system will call the init function once, right before the
                // first frame is to be drawn. it's a good place to set up the canvas and
                // to pass the canvas size to the particle system
                //
                // save a reference to the particle system for use in the .redraw() loop
                particleSystem = system

                // inform the system of the screen dimensions so it can map coords for us.
                // if the canvas is ever resized, screenSize should be called again with
                // the new dimensions
                particleSystem.screenSize(canvas.width, canvas.height) 
                particleSystem.screenPadding(80) // leave an extra 80px of whitespace per side
                
                // set up some event handlers to allow for node-dragging
                that.initMouseHandling()
              },
              
              /*redraw:function(){
                // 
                // redraw will be called repeatedly during the run whenever the node positions
                // change. the new positions for the nodes can be accessed by looking at the
                // .p attribute of a given node. however the p.x & p.y values are in the coordinates
                // of the particle system rather than the screen. you can either map them to
                // the screen yourself, or use the convenience iterators .eachNode (and .eachEdge)
                // which allow you to step through the actual node objects but also pass an
                // x,y point in the screen's coordinate system
                // 
                ctx.fillStyle = "white"
                ctx.fillRect(0,0, canvas.width, canvas.height)
                
                particleSystem.eachEdge(function(edge, pt1, pt2){
                  // edge: {source:Node, target:Node, length:#, data:{}}
                  // pt1:  {x:#, y:#}  source position in screen coords
                  // pt2:  {x:#, y:#}  target position in screen coords

                  // draw a line from pt1 to pt2
                  ctx.strokeStyle = "rgba(0,0,0, .333)"
                  ctx.lineWidth = 1
                  ctx.beginPath()
                  ctx.moveTo(pt1.x, pt1.y)
                  ctx.lineTo(pt2.x, pt2.y)
                  ctx.stroke()
                })

                particleSystem.eachNode(function(node, pt){
                  // node: {mass:#, p:{x,y}, name:"", data:{}}
                  // pt:   {x:#, y:#}  node position in screen coords

                  // draw a rectangle centered at pt
                  var w = 10
                  ctx.fillStyle = (node.data.alone) ? "orange" : "black"
                  ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w)
                })              
              }*/
              redraw:function()
                {
                    ctx.fillStyle = "#EFEFEF";
                    ctx.fillRect (0,0, canvas.width, canvas.height);

                    particleSystem.eachEdge (function (edge, pt1, pt2) {
                        ctx.strokeStyle = "rgba(0,0,0, .733)";
                        ctx.lineWidth = 1;
                        ctx.beginPath ();
                        ctx.moveTo (pt1.x, pt1.y);
                        ctx.lineTo (pt2.x, pt2.y);
                        ctx.stroke ();

                        ctx.fillStyle = "black";
                        ctx.font = 'italic 13px sans-serif';
                        ctx.fillText (edge.data.name, (pt1.x + pt2.x) / 2, (pt1.y + pt2.y) / 2);

                    });

                    particleSystem.eachNode (function (node, pt) {
                        var w = 10;
                        ctx.fillStyle = "orange";
                        ctx.fillRect (pt.x-w/2, pt.y-w/2, w,w);
                        ctx.fillStyle = "black";
                        ctx.font = 'italic 13px sans-serif';
                        ctx.fillText (node.name, pt.x+8, pt.y+8);
                        //ctx.fillText (edge.data.data.name, (pt1.x + pt2.x) / 2, (pt1.y + pt2.y) / 2);
                    });       
                    //ctx.fillText (edge.data.data.name, (pt1.x + pt2.x) / 2, (pt1.y + pt2.y) / 2);
                },
              
              initMouseHandling:function(){
                // no-nonsense drag and drop (thanks springy.js)
                selected = null;
                nearest = null;
                var dragged = null;
                var oldmass = 1
                var mouse_is_down = false;
                var mouse_is_moving = false

                // set up a handler object that will initially listen for mousedowns then
                // for moves and mouseups while dragging
                var handler = {
                    mousemove:function(e){
                    if(!mouse_is_down){
                      var pos = $(canvas).offset();
                      _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
                      nearest = particleSystem.nearest(_mouseP);

                      if (!nearest.node) return false
                      selected = (nearest.distance < 50) ? nearest : null
                      if(selected && selected.node.data.link){
                        dom.addClass('linkable')
                      } else {
                        dom.removeClass('linkable')
                      }
                    }
                    return false
                  },
                  clicked:function(e){
                    var pos = $(canvas).offset();
                    _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
                    dragged = particleSystem.nearest(_mouseP);

                    if (dragged && dragged.node !== null){
                      // while we're dragging, don't let physics move the node
                      dragged.node.fixed = true
                    }

                    $(canvas).bind('mousemove', handler.dragged)
                    $(window).bind('mouseup', handler.dropped)

                    return false
                  },
                  dragged:function(e){
                    var pos = $(canvas).offset();
                    var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)

                    if (dragged && dragged.node !== null){
                      var p = particleSystem.fromScreen(s)
                      dragged.node.p = p
                    }

                    return false
                  },

                  dropped:function(e){
                    if (dragged===null || dragged.node===undefined) return
                    if (dragged.node !== null) dragged.node.fixed = false
                    dragged.node.tempMass = 1000
                    dragged = null
                    $(canvas).unbind('mousemove', handler.dragged)
                    $(window).unbind('mouseup', handler.dropped)
                    _mouseP = null
                    return false
                  }
                }
                
                // start listening
                $(canvas).mousedown(handler.clicked);

              },
              
            }
            return that
          }    

          $(document).ready(function(){
            var sys = arbor.ParticleSystem(1000, 600, 0.5) // create the system with sensible repulsion/stiffness/friction
            //arbor.ParticleSystem({friction:.5, stiffness:600, repulsion:1000})
            sys.parameters({gravity:true, dt:0.005}) // use center-gravity to make the graph settle nicely (ymmv)
            sys.renderer = Renderer("#docs") // our newly created renderer will have its .init() method called shortly by sys...
            
            // add some nodes to the graph and watch it go...
            /*
            var animals = sys.addNode('Animals',{'color':'red','shape':'dot','label':'Animals'});
            var dog = sys.addNode('dog',{'color':'green','shape':'dot','label':'dog'});
            var cat = sys.addNode('cat',{'color':'blue','shape':'dot','label':'cat'});
            

            sys.addEdge(animals, dog);
            sys.addEdge(animals, cat);
            */
            /*sys.addEdge(animals, dog);
            sys.addEdge(animals, cat);    */
            /*sys.addEdge('a','b')
            sys.addEdge('a','c')
            sys.addEdge('a','d')
            sys.addEdge('a','e')
            sys.addEdge('a','g')
            sys.addEdge('b','d')
            
            sys.addNode('TESTE', {alone:true, mass:.250})*/

            // or, equivalently:
            //
             sys.graft({
                nodes:{
                 //joe:{'color':'orange','shape':'dot','label':'joe'},
                }, 
                edges:{
                    <?=$string;?>
                }
            })
            /*sys.graf({
              nodes:{"arbor.js":{color:"red", shape:"dot", alpha:1}, 
              
                     demos:{color:CLR.branch, shape:"dot", alpha:1}, 
                     halfviz:{color:CLR.demo, alpha:0, link:'/halfviz'},
                     atlas:{color:CLR.demo, alpha:0, link:'/atlas'},
                     echolalia:{color:CLR.demo, alpha:0, link:'/echolalia'},

                     docs:{color:CLR.branch, shape:"dot", alpha:1}, 
                     reference:{color:CLR.doc, alpha:0, link:'#reference'},
                     introduction:{color:CLR.doc, alpha:0, link:'#introduction'},

                     code:{color:CLR.branch, shape:"dot", alpha:1},
                     github:{color:CLR.code, alpha:0, link:'https://github.com/samizdatco/arbor'},
                     ".zip":{color:CLR.code, alpha:0, link:'/js/dist/arbor-v0.92.zip'},
                     ".tar.gz":{color:CLR.code, alpha:0, link:'/js/dist/arbor-v0.92.tar.gz'}
                    },
              edges:{
                "arbor.js":{
                  demos:{length:.8},
                  docs:{length:.8},
                  code:{length:.8}
                },
                demos:{halfviz:{},
                       atlas:{},
                       echolalia:{}
                },
                docs:{reference:{},
                      introduction:{}
                },
                code:{".zip":{},
                      ".tar.gz":{},
                      "github":{}
                }
              }
            })*/
            
          })

        })(this.jQuery)
       
        </script>

    </body>
</html>