declare class ProductRestrictionByPostcode {
    popup: Element;
    input: HTMLInputElement;
    button: HTMLButtonElement;
    constructor();
    save_postcode(postcode: any): void;
}
