
const url = 'https://google-news-api1.p.rapidapi.com/search'; // Adding 'health' as a query parameter
const options = {
    method: 'GET',
    headers: {
        'X-RapidAPI-Key': 'a90fe4c5dbmsh01eb87dc4a55c11p1072a2jsn6b69f6649799',
        'X-RapidAPI-Host': 'google-news-api1.p.rapidapi.com'
    }
};

async function fetchHealthArticles() {
    try {
        const response = await fetch(url, options);
        const data = await response.json(); // Parsing JSON data
        console.log(articles);
        // Check if data contains articles
        if (data && data.articles) {
            // Get a random subset of news articles (let's say 3 for this example)
            const randomArticles = getRandomSubset(data.articles, 3);

            // Render the random articles
            renderNews(randomArticles);
        } else {
            console.error('No articles found in the response.');
        }
    } catch (error) {
        console.log(error);
    }
}
function renderNews(articles) {
    const newsContainer = document.querySelector('.news');

    articles.slice(0, 3).forEach(article => {
        // Create a card element for each article
        const card = document.createElement('div');
        card.classList.add('card', 'mb-3'); // Bootstrap card class

        // Construct HTML for the news content
        const newsContent = `
            <div class="card-body">
                <h5 class="card-title">${article.title}</h5>
                <p class="card-text">${article.description}</p>
                <img src="${article.image}" class="card-img-top" alt="News Image" onerror="this.src='fallback-image-url.jpg'">
                <!-- Additional information here -->
                <p class="card-text">Additional information goes here...</p>
                <a href="${article.link}" class="btn btn-primary">Read more</a>
            </div>
        `;

        // Set the inner HTML of the card to the constructed news content
        card.innerHTML = newsContent;

        // Append the card to the container
        newsContainer.appendChild(card);
    });
}
// Call fetchHealthArticles function to fetch and display random health-related articles
fetchHealthArticles();
