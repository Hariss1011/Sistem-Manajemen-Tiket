import os
os.makedirs('public/images/events', exist_ok=True)
W, H = 900, 600
posters = {
    'rock':    ('#1f2160', '#d62660', '#ffc83d', 'rings'),
    'jazz':    ('#0f3d3e', '#f4a259', '#f6e8c3', 'waves'),
    'career':  ('#14142b', '#5b8def', '#e4e2f0', 'grid'),
    'data':    ('#0b3a53', '#2ec4b6', '#ffffff', 'bars'),
    'laravel': ('#3b0d2e', '#ff5a4f', '#ffd2c9', 'blocks'),
    'figma':   ('#2a1b6b', '#a259ff', '#1abcfe', 'blobs'),
    'beach':   ('#0a2f5c', '#ff8a5b', '#ffd6a5', 'sun'),
    'reunion': ('#2b2b2b', '#9b9b9b', '#d9d9d9', 'rings'),
}

def art(kind, a, b, c):
    o = []
    if kind == 'rings':
        for i, r in enumerate([330, 260, 190, 120, 60]):
            o.append(f'<circle cx="640" cy="300" r="{r}" fill="none" stroke="{b if i%2==0 else c}" stroke-width="{18 if i%2==0 else 6}" opacity="{0.95-i*0.1:.2f}"/>')
        o.append(f'<circle cx="640" cy="300" r="26" fill="{c}"/>')
    elif kind == 'waves':
        for i in range(9):
            y = 90 + i*55
            o.append(f'<path d="M-20 {y} C 150 {y-70}, 300 {y+70}, 450 {y} S 750 {y-70}, 920 {y}" fill="none" stroke="{b if i%3 else c}" stroke-width="{10 if i%3 else 4}" opacity="0.9"/>')
    elif kind == 'grid':
        for x in range(10):
            for y in range(7):
                on = (x*3 + y*5) % 4 == 0
                o.append(f'<rect x="{80+x*76}" y="{60+y*76}" width="56" height="56" rx="10" fill="{b if on else c}" opacity="{1 if on else 0.14}"/>')
    elif kind == 'bars':
        for i, h in enumerate([120, 200, 160, 280, 240, 360, 320, 440]):
            o.append(f'<rect x="{90+i*95}" y="{560-h}" width="62" height="{h}" rx="12" fill="{b if i%2 else c}" opacity="{0.95 if i%2 else 0.25}"/>')
    elif kind == 'blocks':
        for x, y, w, h, col in [(120,80,260,200,b),(400,80,180,120,c),(600,150,200,260,b),(160,310,200,180,c),(400,230,180,260,b)]:
            o.append(f'<rect x="{x}" y="{y}" width="{w}" height="{h}" rx="26" fill="{col}" opacity="0.9"/>')
    elif kind == 'blobs':
        o.append(f'<circle cx="300" cy="260" r="190" fill="{b}" opacity="0.9"/>')
        o.append(f'<circle cx="560" cy="330" r="170" fill="{c}" opacity="0.75"/>')
        o.append('<circle cx="430" cy="200" r="110" fill="#fff" opacity="0.18"/>')
    elif kind == 'sun':
        o.append(f'<circle cx="450" cy="330" r="190" fill="{b}"/>')
        for i in range(6):
            o.append(f'<rect x="0" y="{400+i*34}" width="900" height="{14+i*3}" fill="{a}" opacity="0.95"/>')
        o.append(f'<circle cx="450" cy="330" r="190" fill="none" stroke="{c}" stroke-width="6" opacity="0.7"/>')
    return '\n  '.join(o)

for name, (a, b, c, kind) in posters.items():
    svg = (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" width="{W}" height="{H}" '
           f'preserveAspectRatio="xMidYMid slice">\n  <rect width="{W}" height="{H}" fill="{a}"/>\n  {art(kind,a,b,c)}\n</svg>\n')
    open(f'public/images/events/seed-{name}.svg', 'w').write(svg)