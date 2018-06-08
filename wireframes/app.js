import {square, doubleSquare, cube, pyramid} from './models.js';
import {Camera} from './camera.js';
import {toMesh} from './mesh.js';
import {createRenderer} from './render.js';


const canvas = document.querySelector('canvas');
const render = createRenderer(canvas);

const scene = [
    toMesh(cube),
    toMesh(pyramid),
];


scene[0].color = "red";
scene[1].color = "purple";

const camera = new Camera();
camera.pos.z = 200;
camera.zoom = 12;

function animate(time){

    camera.pos.z += 0.1;

    {
        const mesh = scene[0];
        mesh.rotation.x += 0.03;
        mesh.rotation.y += 0.01;
        mesh.position.x = Math.sin(time / 500) * 50;
        mesh.position.y = Math.sin(time / 1000) * 50;
    }
    {
        const mesh = scene[1];
        mesh.rotation.y -= 0.01;
        mesh.position.x = Math.sin(time / 300) * 80;
        mesh.position.y = Math.sin(time / 7000) * 80;
        mesh.position.z = Math.cos(time / 5000) * 1000;
    }

    render(scene, camera);
    requestAnimationFrame(animate);
}

animate(0);
//drawMesh(mesh);