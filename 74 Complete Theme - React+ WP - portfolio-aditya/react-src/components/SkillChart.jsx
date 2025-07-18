import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from "recharts";

export default function SkillBarChart({ skills }) {
  // Guard clause for undefined/null
  if (!skills || skills.length === 0) {
    return <p style={{ padding: "2rem" }}>No skills data available.</p>;
  }

  // Format data for bar chart
  const data = skills.map((skill) => ({
    name: skill.title.rendered,
    level: skill.level,
  }));

  return (
    <section style={{ padding: "2rem" }}>
      <h2>Skill Bar Chart</h2>
      <ResponsiveContainer width="100%" height={400}>
        <BarChart
          data={data}
          margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="name" />
          <YAxis domain={[0, 100]} />
          <Tooltip />
          <Bar dataKey="level" fill="#ff6a4a" />
        </BarChart>
      </ResponsiveContainer>
    </section>
  );
}
