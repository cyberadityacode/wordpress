import React, { useEffect, useState } from "react";
import exportToCSV from "./utils/exportCSV";

export default function App() {
  const [form, setForm] = useState({ name: "", email: "" });
  const [message, setMessage] = useState("");
  const [students, setStudents] = useState([]);

  const [isEditing, setIsEditing] = useState(false);
  const [editId, setEditId] = useState(null);

  const [search, setSearch] = useState("");

  const [sortField, setSortField] = useState("id");
  const [sortOrder, setSortOrder] = useState("asc");

  const [loader, setLoader] = useState(false);

  const [currentPage, setCurrentPage] = useState(1);
  const studentsPerPage = 5;

  const sortedStudents = [...students]
    .filter((student) => {
      const term = search.toLowerCase();
      return (
        student.name.toLowerCase().includes(term) ||
        student.email.toLowerCase().includes(term)
      );
    })
    .sort((a, b) => {
      const aVal = a[sortField].toLowerCase?.() || "";
      const bVal = b[sortField].toLowerCase?.() || "";

      if (aVal < bVal) return sortOrder === "asc" ? -1 : 1;
      if (aVal > bVal) return sortOrder === "desc" ? 1 : -1;
      return 0;
    });

  // pagination calculations
  const indexOfLastStudent = currentPage * studentsPerPage;
  const indexOfFirstStudent = indexOfLastStudent - studentsPerPage;
  const currentStudents = sortedStudents.slice(
    indexOfFirstStudent,
    indexOfLastStudent
  );
  const totalPages = Math.ceil(sortedStudents.length / studentsPerPage);

  // Pagination Handler functions

  const goToNextPage = () => {
    if (currentPage < totalPages) setCurrentPage(currentPage + 1);
  };

  const goToPrevPage = () => {
    if (currentPage > 1) setCurrentPage(currentPage - 1);
  };

  const fetchStudents = async () => {
    setLoader(true);
    try {
      const response = await fetch(
        ReactPlugin2Data.ajaxurl + "?action=get_students"
      );
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
    setCurrentPage(1); //resetting page when search or sort changes
    console.log("AJAX URL:", ReactPlugin2Data?.ajaxurl);
  }, [search, sortField, sortOrder]);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    setLoader(true);
    e.preventDefault();

    const params = new URLSearchParams({
      action: isEditing ? "update_student" : "save_student",
      name: form.name,
      email: form.email,
    });

    if (isEditing) {
      params.append("id", editId);
    }

    try {
      const response = await fetch(ReactPlugin2Data.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params,
      });

      const data = await response.json();
      if (data.success) {
        console.log(data);
        setMessage(data.data.message);
        setTimeout(() => setMessage(""), 3000);
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

    const response = await fetch(ReactPlugin2Data.ajaxurl, {
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

  const handleEdit = async (student) => {
    setForm({ name: student.name, email: student.email });
    setEditId(student.id);
    setIsEditing(true);
  };

  const handleSort = (field) => {
    const order = sortField === field && sortOrder === "asc" ? "desc" : "asc";
    setSortField(field);
    setSortOrder(order);
  };

  return (
    <>
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

          {isEditing && (
            <button
              type="button"
              onClick={() => {
                setIsEditing(false);
                setEditId(null);
                setForm({ name: "", email: "" });
              }}
            >
              Cancel
            </button>
          )}
        </form>

        {message && (
          <p style={{ color: "green", marginTop: "1rem" }}>{message}</p>
        )}

        <h1>Student List</h1>

        <input
          type="text"
          placeholder="Search by Name or Email"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          style={{ marginBottom: "1rem", padding: "5px", width: "300px" }}
        />
        {loader ? (
          <p style={{ color: "blue", fontStyle: "italic" }}>Loading...</p>
        ) : (
          <>
            <table border="1" cellPadding="8" style={{ marginTop: "1rem" }}>
              <thead>
                <tr>
                  <th>ID</th>
                  <th
                    onClick={() => handleSort("name")}
                    style={{
                      cursor: "pointer",
                      color: sortField === "name" ? "blue" : "black",
                    }}
                  >
                    Name
                    {sortField === "name"
                      ? sortOrder === "asc"
                        ? "↑"
                        : "↓"
                      : ""}
                  </th>
                  <th onClick={() => handleSort("email")}>Email </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                {currentStudents.length > 0 ? (
                  currentStudents.map((student) => (
                    <tr key={student.id}>
                      <td>{student.id}</td>
                      <td>{student.name}</td>
                      <td>{student.email}</td>
                      <td>
                        <button onClick={() => handleEdit(student)}>
                          Edit
                        </button>
                        <button onClick={() => handleDelete(student.id)}>
                          Delete
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="4">No Students Found</td>
                  </tr>
                )}
              </tbody>
            </table>
            <div style={{ marginTop: "1rem" }}>
              <button onClick={goToPrevPage} disabled={currentPage === 1}>
                Prev
              </button>
              <span style={{ margin: "0 10px" }}>
                Page {currentPage} of {totalPages}
              </span>
              <button
                onClick={goToNextPage}
                disabled={currentPage === totalPages}
              >
                Next
              </button>
            </div>
          </>
        )}
        <button onClick={() => exportToCSV(students)}>Export CSV</button>
      </div>
    </>
  );
}
