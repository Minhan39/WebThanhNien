const express = require('express');
const path = require('path');
const app = express();

app.use(express.static('public'));

app.get('/:room', (req, res) => {
    res.sendFile(path.join(__dirname, 'views/index.html'));
});

app.get('/images/images.json', (req, res) => {
    res.sendFile(path.join(__dirname, 'images', 'images.json'));
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
}); 