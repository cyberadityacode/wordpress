# React WP Plugin 2

Add Data via React Form to WP Plugin Table
Fetch Data functionality
Delete Functionality
Update Functionality

Search Functionality
Sorting Name Functionality

Export to CSV Functionality

## Pagination

Let's add **pagination** to your student list. You’ll be able to show a limited number of records per page (say, 5) and navigate using **Next / Previous** buttons.

---

## Step-by-Step Plan

### 1. **Add Pagination State**

We'll add:

- `currentPage` to track the page user is on.
- `studentsPerPage` to control how many rows to show.
- `paginatedStudents` to slice the sorted array.

---

### 🔧 Modified React Code (with explanation)

Add the following inside your `App()` component:

#### Step 1: Add these new states

```js
const [currentPage, setCurrentPage] = useState(1);
const studentsPerPage = 5; // change this to show more/less per page
```

#### Step 2: Calculate paginated data

```js
// Pagination calculations
const indexOfLastStudent = currentPage * studentsPerPage;
const indexOfFirstStudent = indexOfLastStudent - studentsPerPage;
const currentStudents = sortedStudents.slice(
  indexOfFirstStudent,
  indexOfLastStudent
);
const totalPages = Math.ceil(sortedStudents.length / studentsPerPage);
```

#### Step 3: Pagination handler functions

```js
const goToNextPage = () => {
  if (currentPage < totalPages) setCurrentPage(currentPage + 1);
};

const goToPrevPage = () => {
  if (currentPage > 1) setCurrentPage(currentPage - 1);
};
```

#### Step 4: Update table rendering

Replace `sortedStudents.map(...)` with `currentStudents.map(...)`:

```jsx
<tbody>
  {currentStudents.length > 0 ? (
    currentStudents.map((student) => (
      <tr key={student.id}>
        <td>{student.id}</td>
        <td>{student.name}</td>
        <td>{student.email}</td>
        <td>
          <button onClick={() => handleEdit(student)}>Edit</button>
          <button onClick={() => handleDelete(student.id)}>Delete</button>
        </td>
      </tr>
    ))
  ) : (
    <tr>
      <td colSpan="4">No Students Found</td>
    </tr>
  )}
</tbody>
```

#### Step 5: Add pagination buttons below table

After the table:

```jsx
<div style={{ marginTop: "1rem" }}>
  <button onClick={goToPrevPage} disabled={currentPage === 1}>
    Prev
  </button>
  <span style={{ margin: "0 10px" }}>
    Page {currentPage} of {totalPages}
  </span>
  <button onClick={goToNextPage} disabled={currentPage === totalPages}>
    Next
  </button>
</div>
```

---

### Result:

You now have a paginated student list:

- Only 5 records are shown per page.
- User can click **Prev / Next** to navigate.
- Works seamlessly with **search** and **sorting** too.

---

### Summary of Key Logic:

| Concept          | Code Used                                         |
| ---------------- | ------------------------------------------------- |
| Total Records    | `sortedStudents.length`                           |
| Records per page | `studentsPerPage`                                 |
| Current slice    | `.slice(indexOfFirstStudent, indexOfLastStudent)` |
| Navigation       | `setCurrentPage()`                                |

---
