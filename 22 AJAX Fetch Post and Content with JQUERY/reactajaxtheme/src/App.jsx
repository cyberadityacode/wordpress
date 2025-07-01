export default function App({ initialData }) {
  const { websiteName, websiteDescription } = initialData;

  return (
    <div>
      <h1>Welcome to React App</h1>
      <p>{websiteName}</p>
      <p>
        {websiteDescription.desc}
        {websiteDescription.url}
      </p>
    </div>
  );
}
