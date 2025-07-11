// utils/importCSV.js

export function parseCSVFile(file, callback) {
  const reader = new FileReader();

  reader.onload = (event) => {
    const text = event.target.result;
    const lines = text.split(/\r?\n/); // handles \n or \r\n
    const students = [];

    for (let i = 1; i < lines.length; i++) {
      const line = lines[i].trim();
      if (!line) continue;

      const [nameRaw, emailRaw] = line.split(",");

      const name = nameRaw?.trim();
      const email = emailRaw?.trim();

      if (name && email) {
        students.push({ name, email });
      }
    }

    callback(students);
  };

  reader.readAsText(file);
}
