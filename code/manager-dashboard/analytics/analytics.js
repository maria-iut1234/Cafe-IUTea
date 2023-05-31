// Call handleAnalyticsOption on page load
window.addEventListener("DOMContentLoaded", function () {
  const dropdown = document.querySelector(
    ".form__input.menu-item-size.analytics"
  );
  const selectedValue = dropdown.value;
  handleAnalyticsOption(selectedValue);
});

function handleAnalyticsOption(value) {
  const revenueTable = document.getElementById("table-daily-revenue");
  const expenseTable = document.getElementById("table-daily-expense");
  const profitTable = document.getElementById("table-daily-profit");

  const revenueTablemonthly = document.getElementById("table-monthly-revenue");
  const expenseTablemonthly = document.getElementById("table-monthly-expense");
  const profitTablemonthly = document.getElementById("table-monthly-profit");

  const nothing = document.getElementById("nothing-selected");

  if (value === "daily-revenue") {
    revenueTable.style.display = "block";
    expenseTable.style.display = "none";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "none";
  } else if (value === "daily-expense") {
    revenueTable.style.display = "none";
    expenseTable.style.display = "block";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "none";
  } else if (value === "daily-profit") {
    revenueTable.style.display = "none";
    expenseTable.style.display = "none";
    profitTable.style.display = "block";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "none";
  } else if (value === "monthly-revenue") {
    revenueTable.style.display = "none";
    expenseTable.style.display = "none";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "block";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "none";
  } else if (value === "monthly-expense") {
    revenueTable.style.display = "none";
    expenseTable.style.display = "none";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "block";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "none";
  } else if (value === "monthly-profit") {
    revenueTable.style.display = "none";
    expenseTable.style.display = "none";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "block";

    nothing.style.display = "none";
  } else {
    revenueTable.style.display = "none";
    expenseTable.style.display = "none";
    profitTable.style.display = "none";

    revenueTablemonthly.style.display = "none";
    expenseTablemonthly.style.display = "none";
    profitTablemonthly.style.display = "none";

    nothing.style.display = "block";
  }
}
