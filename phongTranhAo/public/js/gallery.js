let camera, scene, renderer;
let controls;
const WALL_SIZE = { width: 50, height: 10 };
const ROOM_SIZE = { width: 50, depth: 50 };
const PLAYER = {
    height: 1.6,
    radius: 0.5,  // Bán kính va chạm của người chơi
    speed: 0.1
};

// lấy mã phòng
const pathSegments = window.location.pathname.split('/');
const param = pathSegments[1];

// Thêm biến toàn cục mới
let nearPainting = null;
let labelRenderer;

// Thay thế khai báo PAINTINGS_INFO cũ bằng:
let PAINTINGS_INFO = []; // Sẽ được điền từ file JSON

// Thêm hàm loadPaintingsInfo trước hàm init()
async function loadPaintingsInfo() {
    try {
        const response = await fetch('/images/images.json');
        if (!response.ok) {
            throw new Error('Không thể tải thông tin tranh');
        }
        const jsonData = await response.json();
        // Lấy mảng images từ object JSON
        PAINTINGS_INFO = jsonData.images
        .filter(painting => painting.room === param) 
        .map(painting => ({
            id: painting.id,
            title: painting.title,
            description: painting.description,
            position: {
                x: Number(painting.position.x),
                y: Number(painting.position.y),
                z: Number(painting.position.z)
            },
            size: {
                width: Number(painting.size.width),
                height: Number(painting.size.height)
            },
            rotation: painting.rotation || 0
        }));
        
        // Sau khi tải xong dữ liệu, khởi tạo scene
        init();
        animate();
    } catch (error) {
        console.error('Lỗi khi tải thông tin tranh:', error);
    }
}

// init();
// animate();
loadPaintingsInfo();

function init() {
    // Scene setup
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);

    // Camera setup
    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 1.6, 5);

    // Renderer setup
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Room creation
    createRoom();
    
    // Add paintings
    addPaintings();

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);
    
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
    directionalLight.position.set(0, 10, 0);
    scene.add(directionalLight);

    // Controls
    setupControls();

    // Window resize handler
    window.addEventListener('resize', onWindowResize, false);

    // Thêm CSS2D renderer cho labels
    labelRenderer = new THREE.CSS2DRenderer();
    labelRenderer.setSize(window.innerWidth, window.innerHeight);
    labelRenderer.domElement.style.position = 'absolute';
    labelRenderer.domElement.style.top = '0px';
    labelRenderer.domElement.style.pointerEvents = 'none';
    document.body.appendChild(labelRenderer.domElement);
}

function createRoom() {
    // Floor with texture
    const floorTexture = new THREE.TextureLoader().load('images_core/floor/anh_van_da.jpg');
    // Lặp lại texture để tạo pattern cho sàn
    floorTexture.wrapS = THREE.RepeatWrapping;
    floorTexture.wrapT = THREE.RepeatWrapping;
    floorTexture.repeat.set(8, 8); // Điều chỉnh số lần lặp lại texture

    const floorGeometry = new THREE.PlaneGeometry(50, 50);
    const floorMaterial = new THREE.MeshStandardMaterial({ 
        map: floorTexture,
        side: THREE.DoubleSide,
    });
    const floor = new THREE.Mesh(floorGeometry, floorMaterial);
    floor.rotation.x = -3.14159 / 2;
    scene.add(floor);

    // Walls
    const wallMaterial = new THREE.MeshStandardMaterial({ 
        color: 0xe0e0e0,
        side: THREE.DoubleSide
    });

    // Front wall
    const frontWall = new THREE.Mesh(
        new THREE.PlaneGeometry(50, 10),
        wallMaterial
    );
    frontWall.position.z = 25;
    scene.add(frontWall);
    
    // Back wall
    const backWall = new THREE.Mesh(
        new THREE.PlaneGeometry(50, 10),
        wallMaterial
    );
    backWall.position.z = -25;
    scene.add(backWall);

    // Left wall
    const leftWall = new THREE.Mesh(
        new THREE.PlaneGeometry(50, 10),
        wallMaterial
    );
    leftWall.rotation.y = 3.14159 / 2;
    leftWall.position.x = -25;
    scene.add(leftWall);

    // Right wall
    const rightWall = new THREE.Mesh(
        new THREE.PlaneGeometry(50, 10),
        wallMaterial
    );
    rightWall.rotation.y = -3.14159 / 2;
    rightWall.position.x = 25;
    scene.add(rightWall);

    // Tạo tường hình chữ H với độ dày
    const hWallMaterial = new THREE.MeshStandardMaterial({ 
        color: 0xe0e0e0,
        side: THREE.DoubleSide
    });

    // Tường ngang của chữ H
    const hWallHorizontal = new THREE.Mesh(
        new THREE.BoxGeometry(30, 10, 0.5), // Thêm độ dày 0.5
        hWallMaterial
    );
    hWallHorizontal.position.set(0, 0, 0);
    scene.add(hWallHorizontal);

    // Tường dọc bên trái của chữ H
    const hWallLeft = new THREE.Mesh(
        new THREE.BoxGeometry(30, 10, 0.5), // Thêm độ dày 0.5
        hWallMaterial
    );
    hWallLeft.position.set(-15, 0, 0);
    hWallLeft.rotation.y = 3.14159 / 2;
    scene.add(hWallLeft);

    // Tường dọc bên phải của chữ H
    const hWallRight = new THREE.Mesh(
        new THREE.BoxGeometry(30, 10, 0.5), // Thêm độ dày 0.5
        hWallMaterial
    );
    hWallRight.position.set(15, 0, 0);
    hWallRight.rotation.y = 3.14159 / 2;
    scene.add(hWallRight);
}

function addPaintings() {
    PAINTINGS_INFO.forEach(painting => {
        // Tạo khung tranh
        const frameGeometry = new THREE.BoxGeometry(
            painting.size.width + 0.2, 
            painting.size.height + 0.2, 
            0.1
        );
        const frameMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x000000,
            roughness: 0.5,
            metalness: 0.2
        });
        const frame = new THREE.Mesh(frameGeometry, frameMaterial);
        
        // Tạo tranh chính
        const texture = new THREE.TextureLoader().load(`images/${painting.id}.webp`);
        const geometry = new THREE.PlaneGeometry(painting.size.width, painting.size.height);
        const material = new THREE.MeshBasicMaterial({ map: texture });
        const mesh = new THREE.Mesh(geometry, material);
        
        // Nhóm khung và tranh
        const group = new THREE.Group();
        group.add(frame);
        group.add(mesh);
        mesh.position.z = 0.11; // Đặt tranh hơi nhô ra khỏi khung
        
        group.position.set(painting.position.x, painting.position.y, painting.position.z);
        if (painting.rotation) {
            group.rotation.y = painting.rotation;
        }
        
        group.userData.paintingId = painting.id;
        group.userData.paintingInfo = painting; // Lưu toàn bộ thông tin tranh
        scene.add(group);

        // Tạo label cho title
        const titleDiv = document.createElement('div');
        titleDiv.className = 'painting-label';
        titleDiv.textContent = painting.title;
        titleDiv.style.color = 'black';
        titleDiv.style.fontSize = '16px';
        titleDiv.style.fontFamily = 'Arial';
        titleDiv.style.position = 'absolute';
        titleDiv.style.opacity = '0'; // Ẩn ban đầu
        titleDiv.style.transition = 'opacity 0.3s';

        const titleLabel = new THREE.CSS2DObject(titleDiv);
        
        // Điều chỉnh vị trí label dựa vào hướng của tranh
        if (painting.rotation) {
            if (painting.rotation === 3.14159) { // Tranh ở tường sau
                titleLabel.position.set(0, -painting.size.height/2 - 0.3, -0.1);
            } else { // Tranh ở tường bên
                titleLabel.position.set(
                    painting.rotation > 0 ? 0.2 : -0.2,
                    -painting.size.height/2 - 0.3,
                    0
                );
            }
        } else { // Tranh ở tường trước
            titleLabel.position.set(0, -painting.size.height/2 - 0.3, 0.1);
        }

        group.add(titleLabel);
        
        // Lưu label vào userData để có thể truy cập sau này
        group.userData.titleLabel = titleDiv;

        // Tạo phản chiếu
        const reflectionMaterial = new THREE.MeshBasicMaterial({ 
            map: texture,
            transparent: true,
            opacity: 0.1,
            side: THREE.DoubleSide
        });
        const reflection = new THREE.Mesh(geometry, reflectionMaterial);
        
        // Tính toán vị trí phản chiếu
        if (painting.rotation != 0) {
            // Nếu tranh ở tường bên
            reflection.rotation.set(
                painting.rotation == 3.14159 ? 1.5708 : -1.5708, // Lật ngược ảnh
                0,
                painting.rotation >= 3.14159 ? 3.14159 : (painting.rotation > 0 ? -1.5708 : 1.5708)
            );
            reflection.position.set(
                painting.position.x + (painting.rotation == 3.14159 ? 0 : (painting.rotation > 0 ? 2 : -2)),
                0.01,
                painting.position.z - (painting.rotation == 3.14159 ? 2 : 0)
            );
        } else {
            // Nếu tranh ở tường sau
            reflection.rotation.set(
                -3.14159 / 2, // Lật ngược ảnh
                0,
                3.14159
            );
            reflection.position.set(
                painting.position.x,
                0.01,
                painting.position.z + 2
            );
        }

        scene.add(reflection);
    });
}

function setupControls() {
    const keys = { w: false, a: false, s: false, d: false };
    let touchStartX = 0;
    let isTouching = false;
    
    // Keyboard controls
    document.addEventListener('keydown', (e) => keys[e.key.toLowerCase()] = true);
    document.addEventListener('keyup', (e) => keys[e.key.toLowerCase()] = false);
    
    // Mouse rotation (for desktop)
    document.addEventListener('mousemove', (e) => {
        if (document.pointerLockElement === document.body) {
            const rotSpeed = 0.002;
            camera.rotation.y -= e.movementX * rotSpeed;
        }
    });

    // Touch rotation (for mobile)
    document.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        isTouching = true;
    }, { passive: true });

    document.addEventListener('touchmove', (e) => {
        if (isTouching && e.touches[0].target.id === 'touchArea') {
            const touchX = e.touches[0].clientX;
            const deltaX = touchX - touchStartX;
            const rotSpeed = 0.002;
            camera.rotation.y += deltaX * rotSpeed;
            touchStartX = touchX;
        }
    }, { passive: true });

    document.addEventListener('touchend', () => {
        isTouching = false;
    }, { passive: true });

    document.addEventListener('click', () => {
        // Chỉ kích hoạt pointerLock trên desktop
        if (!isMobileDevice()) {
            document.body.requestPointerLock();
        }
    });

    // Touch controls
    const rotationSpeed = 0.05;
    const moveSpeed = PLAYER.speed;

    // Xử lý các nút di chuyển
    const setupButton = (id, press, release) => {
        const button = document.getElementById(id);
        if (!button) return; // Skip if button doesn't exist
        
        let isPressed = false;
        let pressInterval;

        const startPress = (e) => {
            e.preventDefault();
            if (!isPressed) {
                isPressed = true;
                press();
                pressInterval = setInterval(press, 16);
            }
        };

        const endPress = () => {
            if (isPressed) {
                isPressed = false;
                clearInterval(pressInterval);
                if (release) release();
            }
        };

        button.addEventListener('mousedown', startPress);
        button.addEventListener('touchstart', startPress);
        document.addEventListener('mouseup', endPress);
        document.addEventListener('touchend', endPress);
        document.addEventListener('touchcancel', endPress);
    };

    // Thiết lập các nút
    setupButton('up', () => keys.w = true, () => keys.w = false);
    setupButton('down', () => keys.s = true, () => keys.s = false);
    setupButton('left', () => keys.a = true, () => keys.a = false);
    setupButton('right', () => keys.d = true, () => keys.d = false);
    
    // Chỉ setup nút xoay nếu không phải mobile
    if (!isMobileDevice()) {
        setupButton('rotate-left', () => {
            camera.rotation.y += rotationSpeed;
        });
        setupButton('rotate-right', () => {
            camera.rotation.y -= rotationSpeed;
        });
    }

    // Movement update function
    window.moveCamera = () => {
        const direction = new THREE.Vector3();
        const rotation = camera.rotation.y;

        if (keys.w) {
            direction.z = -Math.cos(rotation) * PLAYER.speed;
            direction.x = -Math.sin(rotation) * PLAYER.speed;
        }
        if (keys.s) {
            direction.z = Math.cos(rotation) * PLAYER.speed;
            direction.x = Math.sin(rotation) * PLAYER.speed;
        }
        if (keys.a) {
            direction.x = -Math.cos(rotation) * PLAYER.speed;
            direction.z = Math.sin(rotation) * PLAYER.speed;
        }
        if (keys.d) {
            direction.x = Math.cos(rotation) * PLAYER.speed;
            direction.z = -Math.sin(rotation) * PLAYER.speed;
        }

        // Tính toán vị trí mới
        const newPosition = camera.position.clone().add(direction);
        
        // Kiểm tra va chạm với tường
        if (checkWallCollision(newPosition)) {
            return; // Không di chuyển nếu va chạm
        }

        // Giới hạn trong phòng
        newPosition.x = Math.max(-ROOM_SIZE.width/2 + PLAYER.radius, 
                               Math.min(ROOM_SIZE.width/2 - PLAYER.radius, newPosition.x));
        newPosition.z = Math.max(-ROOM_SIZE.depth/2 + PLAYER.radius, 
                               Math.min(ROOM_SIZE.depth/2 - PLAYER.radius, newPosition.z));
        
        // Giữ độ cao cố định (đi trên mặt đất)
        newPosition.y = PLAYER.height;

        // Cập nhật vị trí camera
        camera.position.copy(newPosition);
    };

    // Thêm xử lý cho nút info trên mobile
    const infoButton = document.getElementById('infoButton');
    infoButton.addEventListener('click', () => {
        if (nearPainting) {
            showPaintingInfo(nearPainting);
        }
    });

    // Chỉ thêm xử lý phím G cho desktop
    if (!isMobileDevice()) {
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === 'g' && nearPainting) {
                showPaintingInfo(nearPainting);
            }
        });
    }

    // Thêm xử lý đóng popup
    document.getElementById('closeButton').addEventListener('click', () => {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('paintingInfo').style.display = 'none';
    });
    
    document.getElementById('overlay').addEventListener('click', () => {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('paintingInfo').style.display = 'none';
    });
}

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
    labelRenderer.setSize(window.innerWidth, window.innerHeight); // Cập nhật kích thước cho labelRenderer
}

function animate() {
    requestAnimationFrame(animate);
    window.moveCamera();
    checkNearPaintings(); // Thêm kiểm tra khoảng cách đến tranh
    renderer.render(scene, camera);
    labelRenderer.render(scene, camera); // Thêm render cho labels
}

// Thêm hàm mới để kiểm tra va chạm với tường
function checkWallCollision(position) {
    // Khoảng cách tối thiểu từ tường
    const WALL_MARGIN = PLAYER.radius + 0.1;

    // Kiểm tra va chạm với tường phía trước và sau
    if (Math.abs(position.z) > ROOM_SIZE.depth/2 - WALL_MARGIN) {
        return true;
    }

    // Kiểm tra va chạm với tường bên trái và phải
    if (Math.abs(position.x) > ROOM_SIZE.width/2 - WALL_MARGIN) {
        return true;
    }

    // Kiểm tra va chạm với tranh
    for (const painting of getPaintingBoundaries()) {
        if (checkPaintingCollision(position, painting)) {
            return true;
        }
    }

    return false;
}

// Thêm hàm mới để lấy ranh giới của các bức tranh
function getPaintingBoundaries() {
    return [
        {
            x: 0,
            z: -ROOM_SIZE.depth/2 + 0.2,
            width: 3,
            depth: 0.2
        },
        {
            x: -ROOM_SIZE.width/2 + 0.2,
            z: 0,
            width: 0.2,
            depth: 3
        },
        {
            x: ROOM_SIZE.width/2 - 0.2,
            z: 0,
            width: 0.2,
            depth: 3
        },
        // Tường ngang của chữ H
        {
            x: 0,
            z: 0,
            width: 30,   // chiều rộng tường ngang
            depth: 0.5   // độ dày tường
        },
        // Tường dọc bên trái của chữ H
        {
            x: -15,
            z: 0,
            width: 0.5,  // độ dày tường
            depth: 30    // chiều dài tường dọc
        },
        // Tường dọc bên phải của chữ H
        {
            x: 15,
            z: 0,
            width: 0.5,  // độ dày tường
            depth: 30    // chiều dài tường dọc
        }
    ];
}

// Thêm hàm mới để kiểm tra va chạm với tranh
function checkPaintingCollision(position, painting) {
    const halfWidth = painting.width / 2;
    const halfDepth = painting.depth / 2;

    return (position.x > painting.x - halfWidth - PLAYER.radius &&
            position.x < painting.x + halfWidth + PLAYER.radius &&
            position.z > painting.z - halfDepth - PLAYER.radius &&
            position.z < painting.z + halfDepth + PLAYER.radius);
}

// Thêm hàm kiểm tra thiết bị
function isMobileDevice() {
    return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
}

// Thêm hàm kiểm tra khoảng cách đến tranh
function checkNearPaintings() {
    const INTERACTION_DISTANCE = 3;
    const interactHint = document.getElementById('interactHint');
    const infoButton = document.getElementById('infoButton');
    
    // Reset nearPainting
    nearPainting = null;
    
    // Ẩn tất cả các title labels
    scene.children.forEach(child => {
        if (child.type === 'Group' && child.userData.titleLabel) {
            child.userData.titleLabel.style.opacity = '0';
        }
    });
    
    PAINTINGS_INFO.forEach(painting => {
        const distance = new THREE.Vector3(
            painting.position.x - camera.position.x,
            painting.position.y - camera.position.y,
            painting.position.z - camera.position.z
        ).length();
        
        if (distance < INTERACTION_DISTANCE) {
            nearPainting = painting;
            
            // Tìm group tương ứng và hiển thị title
            const paintingGroup = scene.children.find(child => 
                child.type === 'Group' && 
                child.userData.paintingInfo === painting
            );
            
            if (paintingGroup && paintingGroup.userData.titleLabel) {
                paintingGroup.userData.titleLabel.style.opacity = '1';
            }
        }
    });
    
    if (nearPainting) {
        if (isMobileDevice()) {
            infoButton.style.display = 'block';
            interactHint.style.display = 'none';
        } else {
            interactHint.style.display = 'block';
            infoButton.style.display = 'none';
        }
    } else {
        interactHint.style.display = 'none';
        infoButton.style.display = 'none';
    }
}

// Thêm hàm hiển thị thông tin tranh
function showPaintingInfo(painting) {
    const overlay = document.getElementById('overlay');
    const paintingInfo = document.getElementById('paintingInfo');
    const paintingImage = document.getElementById('paintingImage');
    const paintingTitle = document.getElementById('paintingTitle');
    const paintingDescription = document.getElementById('paintingDescription');
    
    paintingImage.src = `images/${painting.id}.webp`;
    paintingTitle.textContent = painting.title;
    paintingDescription.textContent = painting.description;
    
    overlay.style.display = 'block';
    paintingInfo.style.display = 'block';
} 