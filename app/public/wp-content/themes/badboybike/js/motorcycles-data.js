// Motorcycles Data - 10 Custom Builds
const motorcyclesData = [
  {
    id: 1,
    name: "Night Rider V-Rod",
    model: "Harley-Davidson V-Rod",
    year: 2023,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-01/thumb.jpg",
    images: [
      "images/bikes/bike-01/main.jpg",
      "images/bikes/bike-01/side.jpg",
      "images/bikes/bike-01/detail-1.jpg",
      "images/bikes/bike-01/detail-2.jpg"
    ],
    specs: {
      engine: "1250cc Revolution V-Twin",
      power: "125 HP",
      torque: "85 lb-ft",
      weight: "295 kg"
    },
    modifications: [
      "Full custom black powder coat",
      "Lowered suspension system",
      "Custom exhaust with ceramic coating",
      "LED lighting package",
      "Custom leather seat",
      "Performance air intake"
    ],
    description: "Blacked-out custom V-Rod with premium finishes and performance upgrades. This build features aggressive styling with modern LED lighting and a custom exhaust system that delivers both power and an incredible sound.",
    status: "Available"
  },
  {
    id: 2,
    name: "Iron Beast",
    model: "Harley-Davidson Iron 883",
    year: 2023,
    category: "Bobber",
    thumbnail: "images/bikes/bike-02/thumb.jpg",
    images: [
      "images/bikes/bike-02/main.jpg",
      "images/bikes/bike-02/side.jpg",
      "images/bikes/bike-02/detail-1.jpg"
    ],
    specs: {
      engine: "883cc Evolution",
      power: "50 HP",
      torque: "54 lb-ft",
      weight: "256 kg"
    },
    modifications: [
      "Bobber conversion kit",
      "Custom solo seat",
      "Shortened rear fender",
      "Drag handlebars",
      "Custom paint - matte black",
      "Upgraded brakes"
    ],
    description: "Classic bobber styling meets modern reliability. The Iron 883 transformed into a stripped-down machine built for the streets. Minimalist design with maximum attitude.",
    status: "Sold"
  },
  {
    id: 3,
    name: "Street Thunder",
    model: "Harley-Davidson Street Bob",
    year: 2024,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-03/thumb.jpg",
    images: [
      "images/bikes/bike-03/main.jpg",
      "images/bikes/bike-03/side.jpg",
      "images/bikes/bike-03/detail-1.jpg",
      "images/bikes/bike-03/detail-2.jpg"
    ],
    specs: {
      engine: "1868cc Milwaukee-Eight 114",
      power: "93 HP",
      torque: "119 lb-ft",
      weight: "297 kg"
    },
    modifications: [
      "Stage 3 performance upgrade",
      "Custom two-tone paint",
      "Upgraded suspension",
      "Performance exhaust",
      "Custom handlebars",
      "LED lighting conversion"
    ],
    description: "Pure American muscle with modern performance. This Street Bob delivers massive torque and an incredible riding experience. Custom paint and premium upgrades throughout.",
    status: "Available"
  },
  {
    id: 4,
    name: "Café Racer Classic",
    model: "Harley-Davidson Sportster",
    year: 2023,
    category: "Café Racer",
    thumbnail: "images/bikes/bike-04/thumb.jpg",
    images: [
      "images/bikes/bike-04/main.jpg",
      "images/bikes/bike-04/side.jpg",
      "images/bikes/bike-04/detail-1.jpg"
    ],
    specs: {
      engine: "1202cc Revolution Max",
      power: "90 HP",
      torque: "75 lb-ft",
      weight: "221 kg"
    },
    modifications: [
      "Café racer conversion",
      "Rear sets and clip-ons",
      "Custom fuel tank",
      "Upgraded suspension",
      "Performance brakes",
      "Vintage-inspired paint"
    ],
    description: "Modern Sportster transformed into a classic café racer. Lightweight, agile, and stylish. Perfect for carving through city streets with vintage café racer aesthetics.",
    status: "Available"
  },
  {
    id: 5,
    name: "Dark Knight",
    model: "Harley-Davidson Fat Boy",
    year: 2024,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-05/thumb.jpg",
    images: [
      "images/bikes/bike-05/main.jpg",
      "images/bikes/bike-05/side.jpg",
      "images/bikes/bike-05/detail-1.jpg",
      "images/bikes/bike-05/detail-2.jpg"
    ],
    specs: {
      engine: "1868cc Milwaukee-Eight 114",
      power: "93 HP",
      torque: "119 lb-ft",
      weight: "317 kg"
    },
    modifications: [
      "Complete blacked-out theme",
      "Custom wheels and tires",
      "Upgraded audio system",
      "LED accent lighting",
      "Performance exhaust",
      "Custom seat and controls"
    ],
    description: "Commanding presence with blacked-out everything. The Dark Knight Fat Boy is a statement on wheels. Premium upgrades and aggressive styling make this bike unforgettable.",
    status: "Available"
  },
  {
    id: 6,
    name: "Road Warrior",
    model: "Harley-Davidson Road Glide",
    year: 2023,
    category: "Touring",
    thumbnail: "images/bikes/bike-06/thumb.jpg",
    images: [
      "images/bikes/bike-06/main.jpg",
      "images/bikes/bike-06/side.jpg",
      "images/bikes/bike-06/detail-1.jpg"
    ],
    specs: {
      engine: "1923cc Milwaukee-Eight 117",
      power: "105 HP",
      torque: "125 lb-ft",
      weight: "375 kg"
    },
    modifications: [
      "Stage 4 performance kit",
      "Premium audio upgrade",
      "Custom paint and graphics",
      "Upgraded suspension",
      "LED lighting package",
      "Comfort touring seat"
    ],
    description: "Built for the long haul with style and comfort. Road Glide equipped with every premium upgrade for the ultimate touring experience. Power, comfort, and technology combined.",
    status: "Sold"
  },
  {
    id: 7,
    name: "Rusty Rebel",
    model: "Harley-Davidson Softail",
    year: 2023,
    category: "Bobber",
    thumbnail: "images/bikes/bike-07/thumb.jpg",
    images: [
      "images/bikes/bike-07/main.jpg",
      "images/bikes/bike-07/side.jpg",
      "images/bikes/bike-07/detail-1.jpg",
      "images/bikes/bike-07/detail-2.jpg"
    ],
    specs: {
      engine: "1746cc Milwaukee-Eight 107",
      power: "86 HP",
      torque: "111 lb-ft",
      weight: "305 kg"
    },
    modifications: [
      "Rustic patina finish",
      "Custom bobber conversion",
      "Solo seat and fender delete",
      "Ape hanger handlebars",
      "Custom exhaust",
      "Vintage accessories"
    ],
    description: "Vintage aesthetics meet modern performance. The Rusty Rebel embraces the raw, unfinished look with authentic patina and classic bobber lines. A true head-turner.",
    status: "Available"
  },
  {
    id: 8,
    name: "Chrome King",
    model: "Harley-Davidson Heritage Classic",
    year: 2024,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-08/thumb.jpg",
    images: [
      "images/bikes/bike-08/main.jpg",
      "images/bikes/bike-08/side.jpg",
      "images/bikes/bike-08/detail-1.jpg"
    ],
    specs: {
      engine: "1868cc Milwaukee-Eight 114",
      power: "93 HP",
      torque: "119 lb-ft",
      weight: "330 kg"
    },
    modifications: [
      "Full chrome package",
      "Custom leather saddlebags",
      "Upgraded suspension",
      "Premium chrome wheels",
      "Custom paint - pearl white",
      "Sound system upgrade"
    ],
    description: "Classic Heritage styling elevated with premium chrome and custom details. The Chrome King is elegance on two wheels, perfect for riders who appreciate traditional styling.",
    status: "Available"
  },
  {
    id: 9,
    name: "Speed Demon",
    model: "Harley-Davidson Breakout",
    year: 2024,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-09/thumb.jpg",
    images: [
      "images/bikes/bike-09/main.jpg",
      "images/bikes/bike-09/side.jpg",
      "images/bikes/bike-09/detail-1.jpg",
      "images/bikes/bike-09/detail-2.jpg"
    ],
    specs: {
      engine: "1868cc Milwaukee-Eight 114",
      power: "93 HP",
      torque: "119 lb-ft",
      weight: "304 kg"
    },
    modifications: [
      "Performance Stage 3 upgrade",
      "Custom drag bars",
      "Lowered suspension",
      "Performance exhaust",
      "Custom paint - candy red",
      "LED lighting system"
    ],
    description: "Aggressive styling with drag-inspired design. The Speed Demon Breakout is built for those who want to make a statement. Low, long, and loud.",
    status: "Available"
  },
  {
    id: 10,
    name: "Urban Legend",
    model: "Harley-Davidson Low Rider S",
    year: 2023,
    category: "Custom Cruiser",
    thumbnail: "images/bikes/bike-10/thumb.jpg",
    images: [
      "images/bikes/bike-10/main.jpg",
      "images/bikes/bike-10/side.jpg",
      "images/bikes/bike-10/detail-1.jpg"
    ],
    specs: {
      engine: "1923cc Milwaukee-Eight 117",
      power: "105 HP",
      torque: "125 lb-ft",
      weight: "299 kg"
    },
    modifications: [
      "Custom two-tone paint",
      "Upgraded suspension",
      "Performance exhaust system",
      "Custom seat and grips",
      "LED headlight upgrade",
      "Performance air cleaner"
    ],
    description: "The ultimate street performance machine. Urban Legend combines aggressive styling with serious power. Perfect for dominating city streets and weekend rides.",
    status: "Available"
  }
];
