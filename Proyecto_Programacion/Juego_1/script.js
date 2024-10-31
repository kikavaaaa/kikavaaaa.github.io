// Definir las palabras y la cuadrícula
const words = ['JAVASCRIPT', 'HTML', 'CSS', 'REACT', 'NODE'];
const grid = [
    ['J', 'A', 'V', 'A', 'S', 'C', 'R', 'I', 'P', 'T'],
    ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
    ['H', 'T', 'M', 'L', 'A', 'S', 'D', 'F', 'G', 'H'],
    ['Z', 'X', 'C', 'S', 'S', 'V', 'B', 'N', 'M', 'Q'],
    ['N', 'O', 'D', 'E', 'W', 'E', 'R', 'T', 'Y', 'U'],
    ['I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J'],
    ['K', 'L', 'Ñ', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'],
    ['Q', 'W', 'E', 'R', 'E', 'A', 'C', 'T', 'Y', 'U'],
    ['I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J'],
    ['K', 'L', 'Ñ', 'Z', 'X', 'C', 'V', 'B', 'N', 'M']
];

let selectedCells = [];
let foundWords = [];

// Función para crear la cuadrícula en el DOM
function createGrid() {
    const gridContainer = document.getElementById('grid');
    for (let i = 0; i < grid.length; i++) {
        for (let j = 0; j < grid[i].length; j++) {
            const cell = document.createElement('div');
            cell.textContent = grid[i][j];
            cell.className = 'cell';
            cell.dataset.row = i;
            cell.dataset.col = j;
            cell.addEventListener('mousedown', startSelection);
            cell.addEventListener('mouseover', addToSelection);
            cell.addEventListener('mouseup', endSelection);
            gridContainer.appendChild(cell);
        }
    }
}

// Función para mostrar las palabras a buscar
function showWords() {
    const wordList = document.getElementById('word-list');
    words.forEach(word => {
        const li = document.createElement('li');
        li.textContent = word;
        wordList.appendChild(li);
    });
}

// Función para iniciar la selección
function startSelection(e) {
    selectedCells = [e.target];
    e.target.classList.add('selected');
    document.addEventListener('mouseup', endSelection);
}

// Función para añadir celdas a la selección
function addToSelection(e) {
    if (e.buttons === 1 && !selectedCells.includes(e.target)) {
        selectedCells.push(e.target);
        e.target.classList.add('selected');
    }
}

// Función para finalizar la selección
function endSelection() {
    const selectedWord = selectedCells.map(cell => cell.textContent).join('');
    checkWord(selectedWord);
    selectedCells.forEach(cell => cell.classList.remove('selected'));
    selectedCells = [];
    document.removeEventListener('mouseup', endSelection);
}

// Función para verificar si la palabra seleccionada es correcta
function checkWord(selectedWord) {
    const forwardWord = selectedWord;
    const backwardWord = selectedWord.split('').reverse().join('');

    if (words.includes(forwardWord) && !foundWords.includes(forwardWord)) {
        markWord(forwardWord);
        foundWords.push(forwardWord);
    } else if (words.includes(backwardWord) && !foundWords.includes(backwardWord)) {
        markWord(backwardWord);
        foundWords.push(backwardWord);
    }

    if (foundWords.length === words.length) {
        alert('¡Felicidades! Has encontrado todas las palabras.');
    }
}

// Función para marcar una palabra encontrada
function markWord(word) {
    selectedCells.forEach(cell => cell.classList.add('found'));
    const wordItem = [...document.getElementById('word-list').children]
        .find(li => li.textContent === word);
    wordItem.classList.add('found');
}

// Inicializar el juego
createGrid();
showWords();