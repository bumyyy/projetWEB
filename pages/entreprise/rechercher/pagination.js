function pagination(){

document.getElementById('pagination-numbers').innerHTML = ''; // reset la page


//First, get all the elements we’ll need:
const paginationNumbers = document.getElementById("pagination-numbers");
const paginatedList = document.getElementById("main");
const listItems = paginatedList.querySelectorAll("li");
console.log(paginationNumbers, paginatedList, listItems);

const paginationLimit = 5;
const pageCount = Math.ceil(listItems.length / paginationLimit);
let currentPage;

//Now that we know how many pages we’ll need, we can define a function to create a new button 
//for the page number and then add the buttons to the paginationNumbers container.
const appendPageNumber = (index) => {
    const pageNumber = document.createElement("button");
    pageNumber.className = "pagination-number";
    pageNumber.innerHTML = index;
    pageNumber.setAttribute("page-index", index);
    pageNumber.setAttribute("aria-label", "Page " + index);
    paginationNumbers.appendChild(pageNumber);
};

const getPaginationNumbers = () => {
    for (let i = 1; i <= pageCount; i++) {
        appendPageNumber(i);
    }
};

const setCurrentPage = (pageNum) => {
    currentPage = pageNum;

    handleActivePageNumber();   

    const prevRange = (pageNum - 1) * paginationLimit;
    const currRange = pageNum * paginationLimit;

    listItems.forEach((item, index) => {
        item.classList.add("hidden");
        if (index >= prevRange && index < currRange) {
          item.classList.remove("hidden");
        }
      });
};

const handleActivePageNumber = () => {
    document.querySelectorAll(".pagination-number").forEach((button) => {
      button.classList.remove("active");
      
      const pageIndex = Number(button.getAttribute("page-index"));
      if (pageIndex == currentPage) {
        button.classList.add("active");
      }
    });
  };


getPaginationNumbers(); //pour la pagination
setCurrentPage(1);
document.querySelectorAll(".pagination-number").forEach((button) => {
    const pageIndex = Number(button.getAttribute("page-index"));
    if (pageIndex) {
        button.addEventListener("click", () => {
        setCurrentPage(pageIndex);
        });
    }
    });

}