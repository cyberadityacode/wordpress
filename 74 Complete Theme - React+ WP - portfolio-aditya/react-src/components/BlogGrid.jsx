import React, { useEffect, useState } from "react";
import BlogCard from "./BlogCard";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

export default function BlogGrid() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchBlogPosts = async () => {
    try {
      const response = await fetch("/wpaditya/wp-json/wp/v2/posts?per_page=5&_embed");
      const data = await response.json();
      setPosts(data);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBlogPosts();
  }, []);

  if (loading) return <p>Loading...</p>;

  return (
    <section style={{ marginTop: "3rem" }}>
      <h2>Latest Blog Posts</h2>
      <Swiper
        modules={[Navigation, Pagination, Autoplay]}
        spaceBetween={30}
        slidesPerView={1}
        navigation
        pagination={{ clickable: true }}
        autoplay={{ delay: 3000 }}
        breakpoints={{
          640: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        }}
      >
        {posts.map((post) => (
          <SwiperSlide key={post.id}>
            <BlogCard post={post} />
          </SwiperSlide>
        ))}
      </Swiper>
    </section>
  );
}
