"use strict";

const text = require("./text");

const paintings = document.getElementById("paintings");
const container_modal = document.getElementById("container_modal");
const dom = require("./dom");

const pos_y_img_selected = {
    medium: 0.03,
    slow: 0.1,
};

module.exports = (regl) => {
    
    const drawText = text.draw(regl);
    const painting = regl({
        frag: `
	precision lowp float;
	uniform sampler2D tex;
	varying vec3 uv;

	// http://madebyevan.com/shaders/fast-rounded-rectangle-shadows/
	// This approximates the error function, needed for the gaussian integral
	vec4 erf(vec4 x) {
		vec4 s = sign(x), a = abs(x);
		x = 1.0 + (0.278393 + (0.230389 + 0.078108 * (a * a)) * a) * a;
		x *= x;
		return s - s / (x * x);
	}

	// Return the mask for the shadow of a box from lower to upper
	float boxShadow(vec2 lower, vec2 upper, vec2 point, float sigma) {
		vec4 query = vec4(point - lower, upper - point);
		vec4 integral = 0.5 + 0.5 * erf(query * (sqrt(0.5) / sigma));
		return (integral.z - integral.x) * (integral.w - integral.y);
	}

	void main () {
		float frontMask = smoothstep(0.9, 1.0, uv.z);
		float paintingMask = step(0.001, uv.z);
		float shadowAlpha = boxShadow(vec2(.5), vec2(.7), abs(uv.xy-vec2(.5)), 0.02);
		float wrapping = 0.005 * sign(uv.x-.5) * (1.-uv.z);
		float sideShading = pow(uv.z/4.0, 0.1);
		vec3 col = texture2D(tex, uv.xy - vec2(wrapping, 0.)).rgb;
		col *= mix(sideShading, 1., frontMask);
		gl_FragColor = mix(vec4(0.,0.,0.,shadowAlpha), vec4(col,1.), paintingMask);
	}`,
        vert: `
	precision highp float;
	uniform mat4 proj, view, model;
	uniform float yScale;
	attribute vec3 pos;
	varying vec3 uv;
	void main () {
		uv = pos;
		vec4 mpos = model * vec4(pos, 1);
		mpos.y *= yScale;
		gl_Position = proj * view * mpos;
	}`,

        attributes: {
            pos: [
                0,
                0,
                1, //Front
                1,
                0,
                1,
                0,
                1,
                1,
                1,
                1,
                1,
                0,
                0,
                0, //Contour
                1,
                0,
                0,
                0,
                1,
                0,
                1,
                1,
                0,
                -0.1,
                -0.1,
                0, //Shadow
                1.1,
                -0.1,
                0,
                -0.1,
                1.1,
                0,
                1.1,
                1.1,
                0,
            ],
        },

        //count: 6
        elements: [
            0,
            1,
            2,
            3,
            2,
            1, //Front
            1,
            0,
            5,
            4,
            5,
            0, //Contour
            3,
            1,
            7,
            5,
            7,
            1,
            0,
            2,
            4,
            6,
            4,
            2,
            8,
            9,
            4,
            5,
            4,
            9, //Shadow
            9,
            11,
            5,
            7,
            5,
            11,
            11,
            10,
            7,
            6,
            7,
            10,
            10,
            8,
            6,
            4,
            6,
            8,
        ],

        uniforms: {
            model: regl.prop("model"),
            tex: regl.prop("tex"),
        },

        blend: {
            enable: true,
            func: {
                srcRGB: "src alpha",
                srcAlpha: "one minus src alpha",
                dstRGB: "one minus src alpha",
                dstAlpha: 1,
            },
            color: [0, 0, 0, 0],
        },
    });
    console.log("regl painting", painting)
    return function ({ shownBatch, is_same_batch }) {
        if (is_same_batch === false) {
            paintings.innerHTML = "";

            shownBatch.slice(0, 4).forEach((b, i) => {
                paintings.appendChild(createElementPainting(b, i));
            });
        }

        if (paintings.children.length > 0) {
            const prev_id = paintings.dataset.prevselected,
                selected_id = paintings.dataset.selected;
            const prev_element = paintings.children[prev_id],
                element = paintings.children[selected_id];

            shownBatch.slice(0, 4).forEach((b) => {
                if (
                    prev_element &&
                    b.image_id === prev_element.dataset["imgid"]
                ) {
                    if (b.originModel[13] < b.model[13]) {
                        b.model[13] = b.model[13] - pos_y_img_selected.medium;
                        // painting([b]);
                    }
                }

                if (element && b.image_id === element.dataset["imgid"]) {
                    if (
                        b.originModel[13] + 3 * pos_y_img_selected.medium >
                        b.model[13]
                    ) {
                        b.model[13] = b.model[13] + pos_y_img_selected.medium;
                        // painting([b]);
                    }
                }
            });

            // painting(shownBatch.slice(4));
        }
        painting(shownBatch);
        drawText(shownBatch);
    };
};

const createElementPainting = (b, index) => {
    const model = b.model;
    const vec_pos = [model[12], model[13], model[14]];

    const painting = document.createElement("div");
    painting.classList.add("painting");
    const paintingCSS = {
        display: "flex",
        "align-items": "center",
        "font-family": "Arial, sans-serif",
        "font-size": !dom.isDeviceDifferentLaptop() ? "16px" : "30px",
        height: "max-content",
        "background-color": "rgba(0, 0, 0, 0.748)",
        "max-width": "300px",
        padding: "5px 10px",
        color: "white",
        "border-bottom": "1px solid white",
    };
    Object.assign(painting.style, paintingCSS);

    const title = document.createElement("span");
    const space = document.createElement("span");
    const artist = document.createElement("span");
    const selected = document.createElement("span");

    selected.classList.add("selected");

    space.innerText = " - ";

    title.innerText = b.title;
    const titleCSS = {
        "font-weight": "bold",
    };
    Object.assign(title.style, titleCSS);

    artist.innerText = b.artist_title;
    const artistCSS = {
        "font-style": "italic",
    };
    Object.assign(artist.style, artistCSS);

    painting.appendChild(title);
    painting.appendChild(space);
    painting.appendChild(artist);

    painting.dataset.x = vec_pos[0];
    painting.dataset.y = vec_pos[1];
    painting.dataset.z = vec_pos[2];
    painting.dataset.imgid = b.image_id;

    painting.dataset.url = URL.createObjectURL(b.blob);
    painting.dataset.title = b.title;
    painting.dataset["painting_id"] = index;

    painting.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            b.goToModelPos();
        }
    });

    painting.addEventListener("click", (e) => {
        activePainting(index, paintings.dataset.selected);
        handleKeyViewPainting({ code: "Enter" });
    });

    return painting;
};

window.addEventListener("keydown", (e) => {
    handleKeySelectPainting(e);
    handleKeyViewPainting(e);
});

const enterKeyEvent = new KeyboardEvent("keydown", {
    key: "Enter",
    code: "Enter",
    keyCode: 13, // Deprecated but included for backward compatibility
    bubbles: true, // Ensures the event bubbles up
    cancelable: true, // Allows the event to be cancelable
});

const handleKeyViewPainting = (e) => {
    container_modal.style.display = "none";
    //console.log\(.*\)+;
    if (e.code !== "Enter") return;
    let selected_index = paintings.dataset.selected;

    const element = paintings.children[selected_index];
    //console.log\(.*\)+;
    const painting_url = container_modal.querySelector("#painting_url");
    const painting_title = container_modal.querySelector("#painting_title");

    painting_url.src = element.dataset.url;
    painting_title.innerText = element.dataset.title;

    element.dispatchEvent(enterKeyEvent);

    container_modal.style.display = "block";
};

const handleKeySelectPainting = (e) => {
    var keys = {};
    let selected_index = paintings.dataset.selected - 1;
    selected_index += 1;
    const tmp_index = selected_index;
    const length_paintings = paintings.children.length;

    if (
        e.defaultPrevented ||
        e.ctrlKey ||
        e.altKey ||
        e.metaKey ||
        length_paintings === 0
    )
        return;
    keys[e.code] = e.type === "keydown";
    const up = keys["ArrowUp"] ? 1 : 0;
    const down = keys["ArrowDown"] ? 1 : 0;

    if (up === 1) {
        selected_index = selected_index - 1;
    } else if (down === 1) {
        selected_index = selected_index + 1;
    }

    activePainting(selected_index, tmp_index);
};

const activePainting = (index, prev_index) => {
    const length_paintings = paintings.children.length;

    console.log("prev_index", prev_index);
    if (index !== prev_index) {
        const prev_element = paintings.children[prev_index];
        prev_element.style.color = "white";
    }

    if (index >= length_paintings) {
        index = 0;
    } else if (index < 0) {
        index = length_paintings - 1;
    }

    const element = paintings.children[index];
    // console.log(
    //   element,
    //   selected_index,
    //   paintings.children,
    //   length_paintings,
    //   up,
    //   down
    // );
    element.style.color = "red";
    paintings.dataset.selected = index;
    paintings.dataset["prevselected"] = prev_index;

    // e.preventDefault();
};
