const loadInitDOM = () => {
    const div = document.createElement("div"); // container for the paintings
    div.id = "paintings";
    const paintingsCSS = {
        position: "fixed",
        bottom: 0,
        right: 0,
        "z-index": 1000,
        display: "flex",
        "flex-direction": "column",
    };
    div.dataset["selected"] = 0;
    div.dataset["prevselected"] = 0;
    Object.assign(div.style, paintingsCSS);
    document.body.appendChild(div);

    const container_modal = document.createElement("div");
    container_modal.id = "container_modal";

    const modal_view_panting = `<div id="modal" tabindex="-1" style="width: 100%; height: 100%; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.4); z-index:1000;">
  <div style="width: 50%; display: flex; flex-direction: column; align-items: center; gap: 30px; background-color: white; margin: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
    <div>
      <img src="{{your_src}}" alt="painting" class="painting" style="width: 100%; max-width: 50%;" id="painting_url" >
      <h1 id="painting_title">{{your_title}}</h1>
      <span id="close_modal">&#x2715;</span>
    </div>
  </div>
</div>`;
    container_modal.style.zIndex = 1000;
    container_modal.style.display = "none";
    container_modal.innerHTML = modal_view_panting;
    document.body.appendChild(container_modal);

    const icon_close = container_modal.querySelector("span#close_modal");
    const iconCloseCSS = {
      "position": "absolute",
      right: "10px",
      top: 0,
      "font-size": "2rem",
      cursor: "pointer"
    }
    Object.assign(icon_close.style, iconCloseCSS);
    icon_close.addEventListener("click", () => {
      container_modal.style.display = "none";
    })
    // Tạo phần tử hướng dẫn điều khiển
    const controls = document.createElement("div");
    const controlsCSS = {
        position: "fixed",
        backgroundColor: "rgba(0, 0, 0, 0.7)",
        color: "white",
        padding: "10px",
        borderRadius: "5px",
        fontFamily: "Arial, sans-serif",
        zIndex: "1000",
        left: "50%",
        top: "10px",
        transform: "translate(-50%, 0)",
        "user-select": "none",
    };
    Object.assign(controls.style, controlsCSS);

    if (isDeviceDifferentLaptop()) {
        controls.innerHTML = "Chạm để điều khiển.";
    } else {
        controls.innerHTML =
            "Sử dụng các phím W, A, S, D để điều khiển, thoát bằng phím ESC.";
    }
    document.body.appendChild(controls);
};

const isDeviceDifferentLaptop = () =>
    navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i);

module.exports = {
    loadInitDOM,
    isDeviceDifferentLaptop,
};
