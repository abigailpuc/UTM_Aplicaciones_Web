document.addEventListener('DOMContentLoaded', function () {
    const pokemonPerPage = 20; // Número de Pokémon por página
    let currentPage = 1; // Página actual, inicialmente la primera

    // Evento al mostrar el modal de lista de Pokémon
    $('#pokemonListModal').on('shown.bs.modal', function () {
        fetchPokemonList(currentPage);
    });

    // Función para obtener y mostrar la lista de Pokémon por página
    function fetchPokemonList(page) {
        const offset = (page - 1) * pokemonPerPage;
        const pokemonListUrl = `https://pokeapi.co/api/v2/pokemon?limit=${pokemonPerPage}&offset=${offset}`;

        fetch(pokemonListUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo obtener la lista de Pokémon');
                }
                return response.json();
            })
            .then(data => {
                const pokemonList = data.results;
                const pokemonListContainer = document.getElementById('pokemon-list');
                pokemonListContainer.innerHTML = ''; // Limpiar contenido anterior

                pokemonList.forEach(pokemon => {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item';
                    listItem.textContent = pokemon.name;
                    listItem.style.backgroundColor = '#2a2a2a'; // Fondo oscuro
                    listItem.style.color = '#ffffff'; // Texto blanco
                    pokemonListContainer.appendChild(listItem);
                });

                // Mostrar botones de paginación
                renderPaginationButtons();
            })
            .catch(error => {
                console.error('Error al obtener la lista de Pokémon:', error);
            });
    }

    // Función para renderizar los botones de paginación
    function renderPaginationButtons() {
        const paginationButtons = document.getElementById('pagination-buttons');
        paginationButtons.innerHTML = ''; // Limpiar botones anteriores

        // Crear botón de página anterior
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Anterior';
        prevButton.className = 'btn btn-secondary mr-2';
        prevButton.disabled = currentPage === 1; // Deshabilitar si estamos en la primera página
        prevButton.addEventListener('click', () => {
            currentPage--;
            fetchPokemonList(currentPage);
        });
        paginationButtons.appendChild(prevButton);

        // Crear botón de página siguiente
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Siguiente';
        nextButton.className = 'btn btn-secondary';
        nextButton.addEventListener('click', () => {
            currentPage++;
            fetchPokemonList(currentPage);
        });
        paginationButtons.appendChild(nextButton);
    }

    // Evento al hacer clic en el botón de buscar Pokémon
    document.getElementById('fetch-pokemon').addEventListener('click', function () {
        const pokemonName = document.getElementById('pokemon-name').value.toLowerCase();
        fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se encontró el Pokémon');
                }
                return response.json();
            })
            .then(data => {
                const pokemonInfoDiv = document.getElementById('pokemon-info');
                pokemonInfoDiv.innerHTML = `
                    <img src="${data.sprites.front_default}" alt="${data.name}" class="img-fluid">
                    <h2>${data.name}</h2>
                    <p>Número: ${data.id}</p>
                    <p>Altura: ${data.height} dm</p>
                    <p>Peso: ${data.weight} hg</p>
                    <p>Tipo: ${data.types.map(type => type.type.name).join(', ')}</p>
                `;

                // Sintetizar la información del Pokémon en voz
                const synth = window.speechSynthesis;
                const utterance = new SpeechSynthesisUtterance();
                utterance.text = `${data.name}, número ${data.id}, altura ${data.height} decímetros y peso de ${data.weight} hectogramos. Es de tipo ${data.types.map(type => type.type.name).join(', ')}.`;
                synth.speak(utterance);
            })
            .catch(error => {
                const pokemonInfoDiv = document.getElementById('pokemon-info');
                pokemonInfoDiv.innerHTML = `<p style="color: red;">${error.message}</p>`;
            });
    });
});
