$(document).ready(function () {
    const searchInput = $("#search");
    const searchButton = $("#search-button");
    const resultsList = $("#results");
    let timeoutId;

    function performSearch() {
        const query = searchInput.val().trim();

        if (query.length > 0) {
            $.ajax({
                url: "/searchEmails",
                method: "GET",
                data: { query: query },
                success: function (response) {
                    resultsList.empty();

                    if (response.length > 0) {
                        response.forEach(function (email) {
                            resultsList.append(`
                                <li class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <span class="text-gray-800">${email}</span>
                                </li>
                            `);
                        });
                    } else {
                        resultsList.append(`
                            <li class="p-3 text-center text-gray-500">
                                No se encontraron resultados
                            </li>
                        `);
                    }
                },
            });
        } else {
            resultsList.empty();
        }
    }

    searchInput.on("input", function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(performSearch, 300);
    });

    searchButton.on("click", performSearch);

    searchInput.on("keypress", function (e) {
        if (e.which === 13) {
            performSearch();
        }
    });
});
