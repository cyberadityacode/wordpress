import React, { useEffect, useState } from "react";

export default function App() {
  const [form, setForm] = useState({ name: "", email: "" });
  const [message, setMessage] = useState("");
  const [students, setStudents] = useState([]);

  const [loader, setLoader] = useState(false);

  const fetchStudents = async () => {
    setLoader(true);
    try {
      const response = await fetch(window.ajaxurl + "?action=get_students");
      const data = await response.json();

      if (data.success) {
        setStudents(data.data);
      }
    } catch (error) {
      console.error("Error Fetching data ", error);
    } finally {
      setLoader(false);
    }
  };

  useEffect(() => {
    fetchStudents();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    setLoader(true);
    e.preventDefault();

    try {
      const response = await fetch(window.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          action: "save_student",
          name: form.name,
          email: form.email,
        }),
      });

      const data = await response.json();
      if (data.success) {
        console.log(data);
        setMessage(data.data.message);
        setForm({ name: "", email: "" });
        fetchStudents(); //refresh list after saving form
      }
    } catch (error) {
      console.error("Error Submitting Data: ", error);
    } finally {
      setLoader(false);
    }
  };

  const handleDelete = async (id) => {
    const confirmDelete = window.confirm(
      "Are you sure want to delete this student?"
    );
    if (!confirmDelete) return;

    const response = await fetch(window.ajaxurl, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "delete_student",
        id: id,
      }),
    });

    const data = await response.json();
    if (data.success) {
      setMessage(data.data.message);
      setTimeout(() => setMessage(""), 2000);
      fetchStudents(); // refresh list
    } else {
      alert("Failed to Delete Student");
    }
  };

  return (
    <div>
      <h1>Hello React Plugin 2</h1>
      <h2>Add Student</h2>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          value={form.name}
          placeholder="Name"
          onChange={handleChange}
          required
        />
        <br />
        <input
          type="email"
          name="email"
          value={form.email}
          placeholder="Email"
          onChange={handleChange}
          required
        />
        <br />
        <button type="submit">Save</button>
      </form>

      {message && (
        <p style={{ color: "green", marginTop: "1rem" }}>{message}</p>
      )}

      <h1>Student List</h1>

      {loader ? (
        <p style={{ color: "blue", fontStyle: "italic" }}>Loading...</p>
      ) : (
        <>
          <table border="1" cellPadding="8" style={{ marginTop: "1rem" }}>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {students.length > 0 ? (
                students.map((student) => (
                  <tr key={student.id}>
                    <td>{student.id}</td>
                    <td>{student.name}</td>
                    <td>{student.email}</td>
                    <td>
                      <button onClick={() => handleDelete(student.id)}>
                        Delete
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="3">No Students Found</td>
                </tr>
              )}
            </tbody>
          </table>
        </>
      )}
    </div>
  );
}
