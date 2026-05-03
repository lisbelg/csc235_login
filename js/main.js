/**
 * Javascript Main File
 *
 * @author    Joshua Connor <connorj4@southernct.edu>
 * @copyright 2026 
 * @date      2026-02-24
 * @version   1.0
 * @param     none
 * @return    void
 */

console.log("program started");

// go back to the previous page
function goBack() {
  window.history.back();
}

async function fetchUsers() {
  try {
    const response = await fetch('https://jsonplaceholder.typicode.com/users');
    const data = await response.json();

    console.log(data);
    console.table(data);
  } catch (error) {
    console.log('Error:', error);
  }
}

fetchUsers();

console.log("program completed");