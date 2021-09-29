<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkMe.io - View Parking</title>
    <script type="text/javascript" src="https://threejs.org/build/three.js"></script>
    <script type="module" src="https://cdn.rawgit.com/mrdoob/three.js/master/examples/js/loaders/GLTFLoader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.7.7/dat.gui.js"></script>
    <script type="text/javascript" src="https://threejs.org/examples/js/controls/OrbitControls.js"></script>
    <script src="GLTFLoader.js"></script>
    <link rel="apple-touch-icon" href="images\favicon.png">
    <link rel="shortcut icon" href="images\favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        html, body{
            margin: 0;
            padding: 0;
        }
        canvas{
            display: block;
            height: 100vh;
            width: 100vh;
        }
    </style>
</head>
<body>
<?php include_once('includes/sidebar.php');?>
<?php require('includes/dbconnection.php')?>
    <!-- Right Panel -->

   <?php include_once('includes/header.php');?>
   <div class="content">
        <script type="module" src="three.js"></script>
                            
                <script>

                        //create new scene
                        const scene = new THREE.Scene();
                        scene.background = new THREE.Color(0xfff6de); //add back color to scene

                        //creating camera
                        const camera = new THREE.PerspectiveCamera(
                                                45, 
                                                window.innerWidth / window.innerHeight, 
                                                1, 
                                                1000);

                        //creating renderer
                        var renderer = new THREE.WebGLRenderer();

                        //setting renderer to window size
                        renderer.setSize(window.innerWidth, window.innerHeight);
                        //append renderer to body
                        document.body.appendChild(renderer.domElement);

                        //set camera position
                        camera.position.z = 100;

                        var controls = new THREE.OrbitControls(camera, renderer.domElement);
                        controls.update();

                        const upColour = 0xFFFF80;
                        const downColour = 0x4040FF;
                        var light = new THREE.HemisphereLight(upColour, downColour, 0.1);
                        scene.add(light);

                        var abtLight = new THREE.AmbientLight(0x555500, 0);
                        scene.add(abtLight);

                        const directionalLight = new THREE.DirectionalLight(0xffffff, 2);

                        scene.add(directionalLight);

                        const loader = new THREE.GLTFLoader();
                        var model;
                        loader.load('assets/scene.gltf', function (gltf) {
                            model = gltf.scene;
                            scene.add(model);
                            model.position.set(-50,-10,50);
                            model.scale.set(0.05,0.05,0.05);
                        });

                        var position = [
                        {x: '19', y: '-9.2', z: '-32'}, //car1 right
                        {x: '19', y: '-9.2', z: '-26'},
                        {x: '19', y: '-9.2', z: '-20.8'},
                        {x: '19', y: '-9.2', z: '-15.5'},
                        {x: '19', y: '-9.2', z: '-10'},
                        {x: '19', y: '-9.2', z: '-4.5'},
                        {x: '19', y: '-9.2', z: '1'},
                        {x: '19', y: '-9.2', z: '6.0'},
                        {x: '19', y: '-9.2', z: '11.5'},  
                        {x: '10', y: '-9.2', z: '-31.6'}, 
                        {x: '10', y: '-9.2', z: '-25.9'},
                        {x: '10', y: '-9.2', z: '-20.6'},
                        {x: '10', y: '-9.2', z: '-9.6'},
                        {x: '10', y: '-9.2', z: '-15.4'},
                        {x: '10', y: '-9.2', z: '-9.8'},
                        {x: '10', y: '-9.2', z: '-4.4'},
                        {x: '10', y: '-9.2', z: '1.0'},
                        {x: '10', y: '-9.2', z: '6.4'}
                    ];

                    const rightRotation = -1.57;
                    const leftRotation = 1.57;
                    //var parkingNumber = ; 
            </script>

            <?php
                $ret = mysqli_query($con,"select * from vehicles");
                $num= mysqli_num_rows($ret);
                $parkingNumber = [];
                if($num>0){
                    $i = 0;
                    while ($row=mysqli_fetch_array($ret)) {
                        $parkingNumber[] = (int)$row['ParkingNumber'] - 1;
                        $i++;
                    }
                } ?>
                    
                    <script>
                        var parkingNumber = <?php echo json_encode($parkingNumber)?>;

                        for (let i=0;i<parkingNumber.length; i++){
                            loader.load('assets/cars/scene.gltf', function (gltf) {
                            model = gltf.scene;
                            scene.add(model);
                            model.position.set(Number(position[parkingNumber[i]].x),Number(position[parkingNumber[i]].y),Number(position[parkingNumber[i]].z));
                            
                            model.scale.set(0.01,0.01,0.01);
                            model.rotation.y = rightRotation;
                            });
                        }
                    </script>
                    <script>
                        
                    function animate() {
                        requestAnimationFrame(animate);
                        renderer.render(scene, camera);
                    };
                    animate();
                    </script>
                    
    
            <script>          
            
        </script>
   </div>
    
</body>
</html>