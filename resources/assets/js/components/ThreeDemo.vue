<template>
    <div class="container threeDemo">
        <h2>
            Drag to change the view
        </h2>
        <div id="asciiContainer">
        </div>
    </div>

</template>
<script>
    export default {
        mounted() {
            console.log('Three demo component mounted.')
            this.init();
            this.animate();
        },
        data: function() {
            return {
                container: null,
                stats: null,
                camera: null,
                controls: null,
                scene: null,
                renderer: null,
                sphere: null,
                plane: null,
                effect: null,
                start: Date.now(),
            }
        },
        methods: {
            init: function() {
                this.container = document.createElement( 'div' );
                $('#asciiContainer').append( this.container );
                let width = window.innerWidth / 4 || 2;
                let height = window.innerWidth / 4 || 2;
                this.camera = new THREE.PerspectiveCamera( 70, width / height, 1, 1000 );
                this.camera.position.y = 150;
                this.camera.position.z = 500;
                this.controls = new THREE.TrackballControls( this.camera );
                this.controls.rotateSpeed = 3.0;
                this.scene = new THREE.Scene();
                let light = new THREE.PointLight( 0xffffff );
                light.position.set( 500, 500, 500 );
                this.scene.add( light );
                light = new THREE.PointLight( 0xffffff, 0.25 );
                light.position.set( - 500, - 500, - 500 );
                this.scene.add( light );
                this.sphere = new THREE.Mesh( new THREE.SphereGeometry( 200, 20, 10 ), new THREE.MeshLambertMaterial() );
                this.scene.add( this.sphere );
                // Plane
                this.plane = new THREE.Mesh( new THREE.PlaneBufferGeometry( 400, 400 ), new THREE.MeshBasicMaterial( { color: 0xe0e0e0 } ) );
                this.plane.position.y = - 200;
                this.plane.rotation.x = - Math.PI / 2;
                this.scene.add( this.plane );
                this.renderer = new THREE.CanvasRenderer();
                this.renderer.setClearColor( 0xf0f0f0 );
                this.renderer.setSize( width, height );

                this.effect = new THREE.AsciiEffect( this.renderer );
                this.effect.setSize( width, height );
                this.container.appendChild( this.effect.domElement );
                //
                window.addEventListener( 'resize', this.onWindowResize, false );
            },
            onWindowResize: function() {
                this.camera.aspect = window.innerWidth / window.innerHeight;
                this.camera.updateProjectionMatrix();
                this.renderer.setSize( window.innerWidth, window.innerHeight );
                this.effect.setSize( window.innerWidth, window.innerHeight );
            },
            animate: function() {
                requestAnimationFrame( this.animate );

                this.render();
            },
            render: function() {
                let timer = Date.now() - this.start;
                this.sphere.position.y = Math.abs( Math.sin( timer * 0.002 ) ) * 150;
                this.sphere.rotation.x = timer * 0.0003;
                this.sphere.rotation.z = timer * 0.0002;
                this.controls.update();
                this.effect.render( this.scene, this.camera );
            }
        }
    }
</script>

<style lang="scss" scoped>
    div.threeDemo {
        h2 {
            text-align: center;
        }
        div#asciiContainer {
            width: 25vw;
            margin: 0 auto;
        }
    }
</style>
