// call on the first load of the page
ajax("https://api.themoviedb.org/3/movie/now_playing?api_key=d75173d2ccc94f842cab3d939ca4cebd", DisplayMovies);

function ajax(endpoint, func){
	let httpRequest = new XMLHttpRequest();
	httpRequest.open("GET", endpoint);
	httpRequest.send();

	httpRequest.onreadystatechange = function(){
		if(httpRequest.readyState == 4){
			if(httpRequest.status == 200){
				func(httpRequest.responseText);
			}
			else{
				console.log(httpRequest.status);
			}
		}
	}
}
function DisplayMovies(response){
	let jsonObjects = JSON.parse(response);
	// update total and shown movie results
	let total_movies = jsonObjects.total_results;
	document.querySelector("#totalMovies").innerHTML = total_movies;
	if(total_movies < 20){
		document.querySelector("#shownMovies").innerHTML = total_movies;
	}
	else{
		document.querySelector("#shownMovies").innerHTML = "20";
	}
	// clear previous searched movies
	document.querySelector("#movie-container").innerHTML = "";
	// add searched movies
	if(total_movies == 0){   //no movies shown
		let pElem = document.createElement("p");
		pElem.innerHTML = "No results found for \"" + document.querySelector("#searchInput").value.trim() + "\".";
		document.querySelector("#movie-container").appendChild(pElem);
	}
	else{
		for(let i=0; i<jsonObjects.results.length; i++){
		let object = jsonObjects.results[i];
		// create column div
		let colElem = document.createElement("div");
		colElem.classList.add("col-6");
		colElem.classList.add("col-md-4");
		colElem.classList.add("col-lg-3");
		colElem.classList.add("mb-4");
		// create thumbnail div
		let thumbnailElem = document.createElement("div");
		thumbnailElem.classList.add("movie-thumbnail");
		// create poster image
		let imgElem = document.createElement("img");
		if(object.poster_path == null){
			imgElem.src = "https://www.wildhareboca.com/wp-content/uploads/sites/310/2018/03/image-not-available.jpg";
		}
		else{
			imgElem.src = "https://image.tmdb.org/t/p/w500" + object.poster_path;
		}
		// create hover div
		let hoverElem = document.createElement("div");
		hoverElem.classList.add("hover-display");
		hoverElem.classList.add("py-2");
		hoverElem.classList.add("px-2");
		let ratingElem = document.createElement("p");
		ratingElem.classList.add("m-1");
		ratingElem.innerHTML = "Rating: " + object.vote_average;
		let voteAvgElem = document.createElement("p");
		voteAvgElem.classList.add("m-1");
		voteAvgElem.innerHTML = "Number of Voters: " + object.vote_count;
		let summaryElem = document.createElement("p");
		summaryElem.classList.add("m-1");
		if(object.overview.length > 200){
			summaryElem.innerHTML = "Synopsis: " + object.overview.substring(0, 200) + " ...";
		}
		else{
			summaryElem.innerHTML = "Synopsis: " + object.overview;
		}
		// create title and release date
		let titleElem = document.createElement("p");
		titleElem.classList.add("m-1");
		titleElem.innerHTML = object.title;
		let dateElem = document.createElement("p");
		dateElem.classList.add("m-0");
		dateElem.innerHTML = object.release_date;
		// create parent and child relationships
		hoverElem.appendChild(ratingElem);
		hoverElem.appendChild(voteAvgElem);
		hoverElem.appendChild(summaryElem);
		thumbnailElem.appendChild(imgElem);
		thumbnailElem.appendChild(hoverElem);
		colElem.appendChild(thumbnailElem);
		colElem.appendChild(titleElem);
		colElem.appendChild(dateElem);
		document.querySelector("#movie-container").appendChild(colElem);
	}
	}
}
document.querySelector("#search-form").onsubmit = function(event){
	event.preventDefault();
	let searchValue = document.querySelector("#searchInput").value.trim();
	let url = "https://api.themoviedb.org/3/search/movie?api_key=d75173d2ccc94f842cab3d939ca4cebd&query=" + searchValue;
	ajax(url, DisplayMovies);
}
