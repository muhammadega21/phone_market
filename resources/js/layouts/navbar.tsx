import login from '@/routes/login';
import register from '@/routes/register';
import { Link } from '@inertiajs/react';
import { ShoppingCart } from 'lucide-react';

const Navbar = () => {
    return (
        <div className="flex h-20 items-center justify-between border-b border-b-gray-100 bg-white px-20">
            <h1 className="font-karma text-2xl font-bold text-primary">Phone Market</h1>
            <div className="w-md">
                <label className="input w-full">
                    <svg className="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" className="w-full grow" placeholder="Search" />
                </label>
            </div>
            <div className="flex items-center gap-x-5">
                <div className="border-e border-gray-300 pe-5">
                    <Link>
                        <ShoppingCart />
                    </Link>
                </div>
                <div className="flex gap-x-2">
                    <Link href={login.index().url} className="btn btn-outline btn-primary">
                        Masuk
                    </Link>
                    <Link href={register.index().url} className="btn btn-primary">
                        Daftar
                    </Link>
                </div>
            </div>
        </div>
    );
};

export default Navbar;
