import { PropsWithChildren } from 'react';
import Footer from './footer';
import Navbar from './navbar';

const BaseLayout = ({ children }: PropsWithChildren) => {
    return (
        <>
            <Navbar />
            {children}
            <Footer />
        </>
    );
};

export default BaseLayout;
