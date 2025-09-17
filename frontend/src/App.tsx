import Home from "./pages/Home";
import ProjectDetails from "./pages/ProjectDetails";
import { Routes, Route } from "react-router-dom";
import ScrollToTop from "./utils/ScrollToTop";

export default function App() {
  return (
      <>
        <ScrollToTop />
        
        <Routes>
          <Route path="/" element={<Home />} />

          <Route path="/project-details/:id" element={<ProjectDetails />} />
        </Routes>
      </>
  );
}
