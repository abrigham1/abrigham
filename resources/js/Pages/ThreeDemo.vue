<template>
  <MainLayout>
    <template #content-heading>
      Three.js demo
    </template>
    <template #main-content>
      <h2>
        Drag to change the view
      </h2>
      <div id="asciiContainer" class="border-4 border-dashed border-gray-200 rounded-lg h-96" />
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from '@/Layouts/Main'
import {PerspectiveCamera, Color, Scene, PointLight, Mesh, SphereGeometry, MeshPhongMaterial, PlaneGeometry, MeshBasicMaterial, WebGLRenderer} from 'three';
import { AsciiEffect } from 'three/examples/jsm/effects/AsciiEffect';
import { TrackballControls } from 'three/examples/jsm/controls/TrackballControls';

let camera, controls, scene, renderer, effect, container, containerPositionInfo, animationId;

let sphere, plane;

const start = Date.now();

export default {
  components: {
    MainLayout,
  },
  mounted() {
    this.init();
    this.animate();
  },
  beforeUnmount() {
    cancelAnimationFrame(animationId);
    container.removeChild(effect.domElement);
    camera = null;
    controls = null;
    scene = null;
    effect = null;
    containerPositionInfo = null;
    animationId = null;
    container = null;
  },
  methods: {
    init() {
      // container we want to put the animation in
      container = document.getElementById('asciiContainer');
      containerPositionInfo = container.getBoundingClientRect();

      camera = new PerspectiveCamera( 70, containerPositionInfo.width / containerPositionInfo.height, 1, 1000 );
      camera.position.y = 150;
      camera.position.z = 500;

      scene = new Scene();
      scene.background = new Color( 0, 0, 0 );

      const pointLight1 = new PointLight( 0xffffff );
      pointLight1.position.set( 500, 500, 500 );
      scene.add( pointLight1 );

      const pointLight2 = new PointLight( 0xffffff, 0.25 );
      pointLight2.position.set( - 500, - 500, - 500 );
      scene.add( pointLight2 );

      // Sphere
      sphere = new Mesh( new SphereGeometry( 200, 20, 10 ), new MeshPhongMaterial( { flatShading: true } ) );
      scene.add( sphere );

      // Plane
      plane = new Mesh( new PlaneGeometry( 400, 400 ), new MeshBasicMaterial( { color: 0xe0e0e0 } ) );
      plane.position.y = - 200;
      plane.rotation.x = - Math.PI / 2;
      scene.add( plane );

      renderer = new WebGLRenderer();
      renderer.setSize( containerPositionInfo.width, containerPositionInfo.height );

      effect = new AsciiEffect( renderer, ' .:-+*=%@#', { invert: true } );
      effect.setSize( containerPositionInfo.width, containerPositionInfo.height );

      // this has to go before controls or they dont work
      container.appendChild( effect.domElement );

      // Special case: append effect.domElement, instead of renderer.domElement.
      // AsciiEffect creates a custom domElement (a div container) where the ASCII elements are placed.

      controls = new TrackballControls( camera, effect.domElement );
      controls.rotateSpeed = 6.0;

      window.addEventListener( 'resize', this.onWindowResize );
    },
    onWindowResize() {
      containerPositionInfo = container.getBoundingClientRect();
      camera.aspect = containerPositionInfo.width / containerPositionInfo.height;
      camera.updateProjectionMatrix();

      renderer.setSize( containerPositionInfo.width, containerPositionInfo.height );
      effect.setSize( containerPositionInfo.width, containerPositionInfo.height );
    },
    animate() {
      animationId = requestAnimationFrame(this.animate);

      this.render();
    },
    render() {
      let timer = Date.now() - start;
      sphere.position.y = Math.abs(Math.sin(timer * 0.002)) * 150;
      sphere.rotation.x = timer * 0.0003;
      sphere.rotation.z = timer * 0.0002;
      controls.update();
      effect.render(scene, camera);
    }
  }
}
</script>
