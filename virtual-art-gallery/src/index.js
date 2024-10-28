'use strict';

var useReflexion = true;
var showStats = false;

// Handle different screen ratios
const mapVal = (value, min1, max1, min2, max2) => min2 + (value - min1) * (max2 - min2) / (max1 - min1);
var fovX = () => mapVal(window.innerWidth / window.innerHeight, 16 / 9, 9 / 16, 1.7, Math.PI / 3);

if (navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)) {
    useReflexion = false;
    // Account for the searchbar
    fovX = () => mapVal(window.innerWidth / window.innerHeight, 16 / 9, 9 / 16, 1.5, Math.PI / 3);
}
var fovY = () => 2 * Math.atan(Math.tan(fovX() * 0.5) * window.innerHeight / window.innerWidth);

const Stats = require('stats.js');
var stats = new Stats();
stats.showPanel(0);
if (showStats) {
    document.body.appendChild(stats.dom);
}

// Tạo phần tử hướng dẫn điều khiển
const controls = document.createElement('div');
controls.style.position = 'fixed';
controls.style.bottom = '10px';
controls.style.right = '10px';
controls.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
controls.style.color = 'white';
controls.style.padding = '10px';
controls.style.borderRadius = '5px';
controls.style.fontFamily = 'Arial, sans-serif';
controls.style.zIndex = '1000';

if (navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)) {
    controls.innerHTML = "Chạm để điều khiển.";
} else {
    controls.innerHTML = "Sử dụng các phím W, A, S, D để điều khiển, thoát bằng phím ESC.";
}

document.body.appendChild(controls);

let regl, map, drawMap, placement, drawPainting, fps;

regl = require('regl')({
    extensions: [
        //'angle_instanced_arrays',
        'OES_element_index_uint',
        'OES_standard_derivatives'
    ],
    optionalExtensions: [
        //'oes_texture_float',
        'EXT_texture_filter_anisotropic'
    ],
    attributes: { alpha: false }
});

map = require('./map')();
const mesh = require('./mesh');
drawMap = mesh(regl, map, useReflexion);
placement = require('./placement')(regl, map);
drawPainting = require('./painting')(regl);
fps = require('./fps')(map, fovY);

const context = regl({
    cull: {
        enable: true,
        face: 'back'
    },
    uniforms: {
        view: fps.view,
        proj: fps.proj,
        yScale: 1.0
    }
});

const reflexion = regl({
    cull: {
        enable: true,
        face: 'front'
    },
    uniforms: {
        yScale: -1.0
    }
});

regl.frame(({ time }) => {
    stats.begin();
    fps.tick({ time });
    placement.update(fps.pos, fps.fmouse[1], fovX());
    regl.clear({
        color: [0, 0, 0, 1],
        depth: 1
    });
    context(() => {
        if (useReflexion) {
            reflexion(() => {
                drawMap();
                drawPainting(placement.batch());
            });
        }
        drawMap();
        drawPainting(placement.batch());
    });
    stats.end();
});
