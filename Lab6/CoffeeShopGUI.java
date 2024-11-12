import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import javax.imageio.ImageIO;
import java.io.File;
import java.io.IOException;

public class CoffeeShopGUI extends JFrame {
    private JTextField nameField;
    private JTextField quantityField;
    private JTable table;
    private DefaultTableModel model;
    private JTextField totalField;

    public CoffeeShopGUI() {
        initComponents();
    }

    private void initComponents() {
        setTitle("Marlie's Brew Haven");
        setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        setSize(600, 500);
        setLayout(new GridBagLayout());
        setBackground(new Color(238,228,204));
        JLabel backgroundLabel = new JLabel();
        backgroundLabel.setIcon(new ImageIcon("bg.png")); 
        setContentPane(backgroundLabel);
        setLayout(new GridBagLayout());


        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        GridBagConstraints constraints1 = new GridBagConstraints();
        constraints1.anchor = GridBagConstraints.WEST;
        constraints1.insets = new Insets(5, 5, 5, 5);
        
        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(85, 85, Image.SCALE_SMOOTH);
            BufferedImage bufferedImage = new BufferedImage(80, 80, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = bufferedImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 80, 80));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(bufferedImage);
            JLabel logoLabel = new JLabel(logoIcon);
            constraints1.gridx = 4;
            constraints1.gridy = 0;
            add(logoLabel, constraints1);
        } catch (IOException ex) {
            ex.printStackTrace();
        }
        
                
        JLabel nameLabel = new JLabel("Name:");
        constraints1.gridx = 1;
        constraints1.gridy = 0;
        add(nameLabel, constraints1);

        nameField = new JTextField(15);
        constraints1.gridx = 2;
        constraints1.gridy = 0;
        constraints1.insets = new Insets(5, 5, 5, 25);
        nameField.setBackground(Color.WHITE);
        add(nameField, constraints1);

        JLabel orderLabel = new JLabel("Order:");
        constraints1.gridx = 1;
        constraints1.gridy = 1;
        constraints1.insets = new Insets(5, 5, 5, 5);
        add(orderLabel, constraints1);

        String[] orders = {"Iced coffee", "Frappe", "Espresso", "Latte", "Cappuccino", "Mocha", "Americano"};
        JComboBox<String> orderBox = new JComboBox<>(orders);
        orderBox.setPreferredSize(nameField.getPreferredSize());
        constraints1.gridx = 2;
        constraints1.gridy = 1;
        orderBox.setBackground(Color.WHITE);
        add(orderBox, constraints1);

        JLabel orderSizeLabel = new JLabel("Order Size:");
        constraints1.gridx = 1;
        constraints1.gridy = 2;
        add(orderSizeLabel, constraints1);

        ButtonGroup orderSizeGroup = new ButtonGroup();
        JRadioButton smallButton = new JRadioButton("Small");
        JRadioButton mediumButton = new JRadioButton("Medium");
        JRadioButton largeButton = new JRadioButton("Large");
        orderSizeGroup.add(smallButton);
        orderSizeGroup.add(mediumButton);
        orderSizeGroup.add(largeButton);
        JPanel sizePanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 0, 0));
        sizePanel.setBackground(Color.WHITE);
        smallButton.setBackground(sizePanel.getBackground());
        mediumButton.setBackground(sizePanel.getBackground());
        largeButton.setBackground(sizePanel.getBackground());
        sizePanel.add(smallButton);
        sizePanel.add(mediumButton);
        sizePanel.add(largeButton);
        constraints1.gridx = 2;
        constraints1.gridy = 2;
        constraints1.anchor = GridBagConstraints.WEST;
        constraints1.ipadx = 0;
        add(sizePanel, constraints1);

        ButtonGroup orderTypeGroup = new ButtonGroup();
        JRadioButton type1Button = new JRadioButton("Hot");
        JRadioButton type2Button = new JRadioButton("Cold");
        orderTypeGroup.add(type1Button);
        orderTypeGroup.add(type2Button);
        JPanel radioPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 0, 0));
        radioPanel.setBackground(Color.WHITE);
        type1Button.setBackground(radioPanel.getBackground());
        type2Button.setBackground(radioPanel.getBackground());
        radioPanel.add(type1Button);
        radioPanel.add(type2Button);
        constraints1 = new GridBagConstraints();
        constraints1.anchor = GridBagConstraints.WEST;
        constraints1.insets = new Insets(5, 5, 5, 5);
        constraints1.gridx = 2;
        constraints1.gridy = 3;
        add(radioPanel, constraints1);

        JLabel orderTypeLabel = new JLabel("Order Type:");
        constraints1.gridx = 1;
        constraints1.gridy = 3;
        add(orderTypeLabel, constraints1);

        JLabel quantityLabel = new JLabel("Qty:");
        constraints1.gridx = 3;
        constraints1.gridy = 1;
        add(quantityLabel, constraints1);

        quantityField = new JTextField(5);
        constraints1.gridx = 4;
        constraints1.gridy = 1;
        quantityField.setBackground(Color.WHITE);
        add(quantityField, constraints1);

        String[] columns = {"Order (Name, Size, Type)", "Quantity", "Amount"};
        model = new DefaultTableModel(columns, 0);
        table = new JTable(model);
        table.getTableHeader().setFont(table.getTableHeader().getFont().deriveFont(Font.BOLD, 15));
        table.getTableHeader().setForeground(Color.WHITE);
        table.getTableHeader().setBackground(new Color(108, 52, 40)); 
        table.setBackground(Color.LIGHT_GRAY);
        JScrollPane scrollPane = new JScrollPane(table);
        scrollPane.setPreferredSize(new Dimension(400, 150));
        constraints1.gridx = 0;
        constraints1.gridy = 4;
        constraints1.gridwidth = 5;
        add(scrollPane, constraints1);
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(JLabel.CENTER);
        table.setDefaultRenderer(Object.class, centerRenderer);

        JLabel totalAmountLabel = new JLabel("                         TOTAL:");
        totalAmountLabel.setFont(totalAmountLabel.getFont().deriveFont(Font.BOLD, totalAmountLabel.getFont().getSize() + 7f));
        totalAmountLabel.setForeground(Color.BLACK);
       
        constraints1.gridx = 2;
        constraints1.gridy = 5;
        add(totalAmountLabel, constraints1);

       totalField = new JTextField("     0.00", 10);
       totalField.setEditable(false);
       totalField.setPreferredSize(new Dimension(totalField.getPreferredSize().width, totalField.getPreferredSize().height + 15)); 
       constraints1.gridx = 3;
       constraints1.gridy = 5;
       constraints1.gridwidth = 2;
       add(totalField, constraints1);



        JButton manualAddButton = new JButton("Add");
        manualAddButton.setFont(manualAddButton.getFont().deriveFont(Font.BOLD,15));
        manualAddButton.setBackground(new Color(92, 64, 51)); 
        manualAddButton.setForeground(Color.WHITE);
        manualAddButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String name = nameField.getText();
                String order = null;
                String orderType = null;
                String orderSize = null;

                if (smallButton.isSelected()) {
                    orderSize = "Small";
                } else if (mediumButton.isSelected()) {
                    orderSize = "Medium";
                } else if (largeButton.isSelected()) {
                    orderSize = "Large";
                }

                if (type1Button.isSelected()) {
                    orderType = "Hot";
                } else if (type2Button.isSelected()) {
                    orderType = "Cold";
                } 

                if (orderBox.getSelectedIndex() != -1) {
                    order = orders[orderBox.getSelectedIndex()];
                }

                String quantity = quantityField.getText();

                if (!name.isEmpty() && order != null && orderSize != null && orderType != null && !quantity.isEmpty()) {
                    double amount = 0.0;
                    switch (orderBox.getSelectedIndex()) {
                        case 0: // Iced coffee
                            amount = 40.0;
                            break;
                        case 1: // Frappe
                            amount = 60.0;
                            break;
                        case 2: // Espresso
                            amount = 70.0;
                            break;
                        case 3: // Latte
                            amount = 100.0;
                            break;
                        case 4: // Cappuccino
                            amount = 90.0;
                            break;
                        case 5: // Mocha
                            amount = 100.0;
                            break;
                        case 6: // Americano
                            amount = 85.0;
                            break;
                    }

                    double totalAmount = Double.parseDouble(quantity) * amount;
                    model.addRow(new Object[]{order + " (" + name + ", " + orderSize + ", " + orderType + ")", quantity, String.format("%.2f", totalAmount)});
                    updateTotalAmount();

                    nameField.setText("");
                    quantityField.setText("");
                    orderBox.setSelectedIndex(-1);
                    orderSizeGroup.clearSelection();
                    orderTypeGroup.clearSelection();
                } else {
                    JOptionPane.showMessageDialog(CoffeeShopGUI.this, "Name, order, order size, order type, and quantity cannot be empty.");
                }
            }
        });
        constraints1.gridx = 3;
        constraints1.gridy = 6;
        constraints1.gridwidth = 1;
        add(manualAddButton, constraints1);

        JButton clearButton = new JButton("Clear");
        clearButton.setFont(clearButton.getFont().deriveFont(Font.BOLD,15));
        clearButton.setBackground(new Color(92, 64, 51)); 
        clearButton.setForeground(Color.WHITE);
        clearButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.setRowCount(0);
                updateTotalAmount();
            }
        });
        constraints1.gridx = 4;
        constraints1.gridy = 6;
        add(clearButton, constraints1);

        setLocationRelativeTo(null);
    }

    private void updateTotalAmount() {
        double totalAmount = 0.0;
        for (int row = 0; row < model.getRowCount(); row++) {
            String amountStr = (String) model.getValueAt(row, 2);
            totalAmount += Double.parseDouble(amountStr);
        }
        totalField.setText(String.format("     %.2f", totalAmount));
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
            	CoffeeShopGUI frame = new CoffeeShopGUI();
                frame.setVisible(true);
            }
        });
    }
}
