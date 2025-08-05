<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::with(['category', 'chapters'])->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Author',
            'ISBN',
            'Chapter',
            'Category',
        ];
    }

    public function map($book): array
    {
        return [
            $book->title,
            $book->author,
            $book->isbn,
            $book->category ? $book->category->name : '-', 
        ];
    }
}
