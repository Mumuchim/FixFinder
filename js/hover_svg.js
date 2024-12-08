 // Select all paths and the text element
 const paths = document.querySelectorAll('.allPaths');
 const hoveredId = document.getElementById('hoveredId');

 // Add hover event listeners
 paths.forEach(path => {
   path.addEventListener('mouseenter', () => {
     // Update the text content with the ID of the hovered element
     hoveredId.textContent = path.id;
   });
   path.addEventListener('mouseleave', () => {
     // Reset the text content when no element is hovered
     hoveredId.textContent = "MAP NAME";
   });
 });