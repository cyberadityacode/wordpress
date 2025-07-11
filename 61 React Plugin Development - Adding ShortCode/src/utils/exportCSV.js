// exportCSV.js
export default function exportToCSV(students, filename = "students.csv") {
  if (!students || students.length === 0) {
    alert("No student data to export");
    return;
  }

  // CSV Header
  const headers = Object.keys(students[0]);
  const rows = students.map(student =>
    headers.map(header => `"${student[header] ?? ""}"`).join(",")
  );

  // Combine rows
  const csvContent = [headers.join(","), ...rows].join("\n");

  // Create a Blob
  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);

  // Auto download
  const link = document.createElement("a");
  link.href = url;
  link.setAttribute("download", filename);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
