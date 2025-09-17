import { Element } from "react-scroll";
import HeroBanner from "../components/HeroBanner";
import About from "./About";
import Specializations from "./Specializations";
import Resume from "./Resume";
import Skills from "./Skills";
import Projects from "./Projects";
import NavBar from "../components/NavBar";
import Certifications from "./Certifications";
import Footer from "./Footer";
import Contact from "./Contact";

export default function Home() {

    return (
        <>
            <NavBar />
            
            <Element name="home" id="home">
                <HeroBanner />
            </Element>

            <Element name="about" id="about">
                <About />
            </Element>

            <Element name="specializations" id="specializations">
                <Specializations />
            </Element>

            <Element name="resume" id="resume">
                <Resume />
            </Element>

            <Element name="skills" id="skills">
                <Skills />
            </Element>

            <Element name="projects" id="projects">
                <Projects />
            </Element>

            <Element name="certifications" id="certifications">
                <Certifications />
            </Element>

            <Element name="contact" id="contact">
                <Contact />
            </Element>

            <Footer />
        </>
    );
}
