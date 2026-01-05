export interface Auth {
    user: User;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Banner {
    id: number;
    image: string;
    url: string;
}

export interface Category {
    id: number;
    photo: string;
    name: string;
    slug: string;
}

export interface Brand {
    id: number;
    logo: string;
    name: string;
    slug: string;
}

export interface Specification {
    id: number;
    name: string;
    value: string;
}

export interface Phone {
    id: number;
    name: string;
    slug: string;
    thumbnail: string;
    description: string;
    price: number;
    stock: number;
    is_featured: boolean;
    category: Category;
    brand: Brand;
    specifications: Specification[];
}
